<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Core\Repositories\SubscribersListRepository;
use Webkul\Customer\Repositories\CustomerGroupRepository;
use Webkul\GraphQLAPI\Validators\Customer\CustomException;

class RegistrationMutation extends Controller
{
    /**
     * Contains current guard
     *
     * @var array
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CustomerRepository $customerRepository,
        protected CustomerGroupRepository $customerGroupRepository,
        protected SubscribersListRepository $subscriptionRepository
    ) {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);
    }

    /**
     * Method to store user's sign up form data to DB.
     *
     * @return \Illuminate\Http\Response
     */
    public function signUp($rootValue, array $args , GraphQLContext $context)
    {
        $validator = Validator::make($args, [
            'email'                 => 'email|required|unique:customers,email',
            'first_name'            => 'string|required',
            'last_name'             => 'string|required',
            'password'              => 'min:6|required',
            'password_confirmation' => 'required|required_with:password|same:password',
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        $this->create($args);

        if (core()->getConfigData('customer.settings.email.verification')) {
            return [
                'status'  => false,
                'success' => trans('bagisto_graphql::app.shop.customers.signup.success-verify'),
            ];
        }

        return $this->login($args);
    }

    /**
     * Method to store user's sign up form data to DB.
     *
     * @return \Illuminate\Http\Response
     */
    public function socialSignIn($rootValue, array $args , GraphQLContext $context)
    {
        $validator = Validator::make($args, [
            'email'       => 'email|required',
            'first_name'  => 'string|required',
            'last_name'   => 'string|required',
            'signup_type' => 'string|required',
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        if ($args['signup_type'] == 'truecaller') {
            if (empty($args['phone'])) {
                throw new CustomException(trans('bagisto_graphql::app.shop.customers.login.validation.required', ['field' => 'phone number']));
            }

            $customer = $this->customerRepository->findOneByField('phone', $args['phone']);

            if (
                $customer
                && $customer->email != $args['email']
            ) {
                throw new CustomException(
                    trans('bagisto_graphql::app.shop.customers.login.validation.unique', ['phone' => $args['phone']])
                );
            }
        } else {
            $customer = $this->customerRepository->findOneByField('email', $args['email']);
        }

        $args['password'] = $args['password_confirmation'] = $password = rand(000000,999999);

        if (! $customer) {
            $customer = $this->create($args);
        }

        return $this->login($args, $password);
    }

    /**
     *
     * @param mixed $data
     * @return mixed
     */
    public function create($data)
    {
        $data = array_merge($data, [
            'api_token'                 => Str::random(80),
            'customer_group_id'         => $this->customerGroupRepository->findOneByField('code', 'general')->id,
            'is_verified'               => ! core()->getConfigData('customer.settings.email.verification'),
            'password'                  => bcrypt($data['password']),
            'subscribed_to_news_letter' => $data['subscribed_to_news_letter'] ?? 0,
            'token'                     => md5(uniqid(rand(), true)),
        ]);

        Event::dispatch('customer.registration.before');

        $customer = $this->customerRepository->create($data);

        if (! $customer) {
            return [
                'status'  => false,
                'success' => trans('bagisto_graphql::app.shop.customers.signup.error-registration'),
            ];
        }

        if (isset($data['is_subscribed'])) {
            $subscription = $this->subscriptionRepository->findOneWhere(['email' => $data['email']]);

            if ($subscription) {
                $this->subscriptionRepository->update([
                    'customer_id' => $customer->id,
                ], $subscription->id);
            } else {
                Event::dispatch('customer.subscription.before');

                $subscription = $this->subscriptionRepository->create([
                    'channel_id'    => core()->getCurrentChannel()->id,
                    'customer_id'   => $customer->id,
                    'email'         => $data['email'],
                    'is_subscribed' => 1,
                    'token'         => uniqid(),
                ]);

                Event::dispatch('customer.subscription.after', $subscription);
            }
        }

        Event::dispatch('customer.registration.after', $customer);

        return $customer;
    }

    public function login($data, $password = null)
    {
        if (! $jwtToken = JWTAuth::attempt([
                'email'    => $data['email'],
                'password' => $data['password_confirmation'],
            ], $data['remember'] ?? 0)
        ) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.login.invalid-creds'));
        }

        $loginCustomer = auth()->user();

        if (! empty($password)) {
            $this->customerRepository->update([
                'password' => $password,
            ], $loginCustomer->id);
        } else {
            request()->merge([
                'token' => $jwtToken,
            ]);

            if (! $loginCustomer->status) {
                auth()->logout();

                return [
                    'status'  => false,
                    'success' => trans('bagisto_graphql::app.shop.customers.login.not-activated'),
                ];
            }

            if (! $loginCustomer->is_verified) {
                Cookie::queue(Cookie::make('enable-resend', 'true', 1));

                Cookie::queue(Cookie::make('email-for-resend', $loginCustomer->email, 1));

                auth()->logout();

                return [
                    'status'  => false,
                    'success' => trans('bagisto_graphql::app.shop.customers.login.verify-first'),
                ];
            }
        }

        Event::dispatch('customer.after.login', $loginCustomer->email);

        return [
            'status'       => true,
            'success'      => trans('bagisto_graphql::app.shop.customers.success-login'),
            'access_token' => 'Bearer '.$jwtToken,
            'token_type'   => 'Bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
            'customer'     => $this->customerRepository->find($loginCustomer->id),
        ];
    }
}
