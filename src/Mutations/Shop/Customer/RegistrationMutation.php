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

        $this->middleware('auth:'.$this->guard, ['except' => ['register']]);
    }

    /**
     * Method to store user's sign up form data to DB.
     *
     * @return \Illuminate\Http\Response
     */
    public function register($rootValue, array $args , GraphQLContext $context)
    {
        if (empty($args['input'])) {
            throw new CustomException(trans('bagisto_graphql::app.shop.response.error.invalid-parameter'),);
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'first_name'            => 'string|required',
            'last_name'             => 'string|required',
            'email'                 => 'email|required|unique:customers,email',
            'password'              => 'min:6|required',
            'password_confirmation' => 'required|required_with:password|same:password',
        ]);

        if ($validator->fails()) {
            $errorMessage = [];

            foreach ($validator->messages()->toArray() as $field => $message) {
                $errorMessage[] = is_array($message) ? $field .': '. $message[0] : $field .': '. $message;
            }

            throw new CustomException(implode(", ", $errorMessage));
        }

        $this->create($data);

        if (core()->getConfigData('customer.settings.email.verification')) {
            return [
                'status'  => false,
                'success' => trans('shop::app.customers.signup-form.success-verify'),
            ];
        }

        return $this->login($data);
    }

    /**
     * Method to store user's sign up form data to DB.
     *
     * @return \Illuminate\Http\Response
     */
    public function socialSignIn($rootValue, array $args , GraphQLContext $context)
    {
        $data = $args;

        $validator = Validator::make($data, [
            'first_name'  => 'string|required',
            'last_name'   => 'string|required',
            'email'       => 'email|required',
            'signup_type' => 'string|required',
        ]);

        if ($validator->fails()) {
            $errorMessage = [];

            foreach ($validator->messages()->toArray() as $field => $message) {
                $errorMessage[] = is_array($message) ? $field .': '. $message[0] : $field .': '. $message;
            }

            throw new CustomException(implode(", ", $errorMessage));
        }

        if ($data['signup_type'] == 'truecaller') {
            if (empty($data['phone'])) {
                throw new CustomException(trans('bagisto_graphql::app.shop.customer.login-form.validation.required', ['field' => 'phone number']));
            }

            $customer = $this->customerRepository->findOneByField('phone', $data['phone']);

            if (
                $customer
                && $customer->email != $data['email']
            ) {
                throw new CustomException(
                    trans('bagisto_graphql::app.shop.customer.login-form.validation.unique', ['phone' => $data['phone']])
                );
            }
        } else {
            $customer = $this->customerRepository->findOneByField('email', $data['email']);
        }

        $data['password'] = $data['password_confirmation'] = rand(000000,999999);

        if (! $customer) {
            $customer = $this->create($data);
        }

        $password = $customer->password;

        $customer->update([
            'password' => bcrypt($data['password']),
        ]);

        return $this->login($data, $password);
    }

    /**
     *
     * @param mixed $data
     * @return mixed
     */
    public function create($data)
    {
        $data = array_merge($data, [
            'password'                  => bcrypt($data['password']),
            'api_token'                 => Str::random(80),
            'is_verified'               => ! core()->getConfigData('customer.settings.email.verification'),
            'subscribed_to_news_letter' => $data['subscribed_to_news_letter'] ?? 0,
            'customer_group_id'         => $this->customerGroupRepository->findOneByField('code', 'general')->id,
            'token'                     => md5(uniqid(rand(), true)),
        ]);

        Event::dispatch('customer.registration.before');

        $customer = $this->customerRepository->create($data);

        if (! $customer) {
            return [
                'status'  => false,
                'success' => trans('bagisto_graphql::app.shop.customer.signup-form.error-registration'),
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
                    'email'         => $data['email'],
                    'customer_id'   => $customer->id,
                    'channel_id'    => core()->getCurrentChannel()->id,
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
            throw new CustomException(trans('bagisto_graphql::app.shop.customer.login-form.invalid-creds'));
        }

        $loginCustomer = auth()->guard()->user();

        if (! empty($password)) {
            $this->customerRepository->update([
                'password' => $password,
            ], $loginCustomer->id);
        } else {
            if (! $loginCustomer->status) {
                auth()->guard()->logout();

                return [
                    'status'  => false,
                    'success' => trans('shop::app.customers.login-form.not-activated'),
                ];
            }

            if (! $loginCustomer->is_verified) {
                Cookie::queue(Cookie::make('enable-resend', 'true', 1));

                Cookie::queue(Cookie::make('email-for-resend', $loginCustomer->email, 1));

                auth()->guard()->logout();

                return [
                    'status'  => false,
                    'success' => trans('shop::app.customers.login-form.verify-first'),
                ];
            }
        }

        Event::dispatch('customer.after.login', $loginCustomer->email);

        return [
            'status'       => true,
            'success'      => trans('bagisto_graphql::app.shop.customer.success-login'),
            'access_token' => 'Bearer '.$jwtToken,
            'token_type'   => 'Bearer',
            'expires_in'   => auth()->guard()->factory()->getTTL() * 60,
            'customer'     => $this->customerRepository->find($loginCustomer->id),
        ];
    }
}
