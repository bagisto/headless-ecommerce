<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Exception;
use JWTAuth;
use Webkul\GraphQLAPI\Validators\Customer\CustomException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Webkul\Customer\Mail\RegistrationEmail;
use Webkul\Customer\Mail\VerificationEmail;
use Webkul\Customer\Http\Controllers\Controller;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Customer\Repositories\CustomerGroupRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class RegistrationMutation extends Controller
{
    /**
     * Contains current guard
     *
     * @var array
     */
    protected $guard;

    /**
     * CustomerRepository object
     *
     * @var \Webkul\Customer\Repositories\CustomerRepository
     */
    protected $customerRepository;

    /**
     * CustomerGroupRepository object
     *
     * @var \Webkul\Customer\Repositories\CustomerGroupRepository
     */
    protected $customerGroupRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Customer\Repositories\CustomerRepository  $customerRepository
     * @param  \Webkul\Customer\Repositories\CustomerGroupRepository  $customerGroupRepository
     * @return void
     */
    public function __construct(
        CustomerRepository $customerRepository,
        CustomerGroupRepository $customerGroupRepository
    )
    {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);
        
        $this->middleware('auth:' . $this->guard, ['except' => ['register']]);
        
        $this->customerRepository = $customerRepository;

        $this->customerGroupRepository = $customerGroupRepository;
    }

    /**
     * Method to store user's sign up form data to DB.
     *
     * @return \Illuminate\Http\Response
     */
    public function register($rootValue, array $args , GraphQLContext $context)
    {
        if (! isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new CustomException(
                trans('bagisto_graphql::app.admin.response.error-invalid-parameter'),
                'Invalid request parameters.'
            );
        }
    
        $data = $args['input'];

        $validationArray = [
            'first_name' => 'string|required',
            'last_name'  => 'string|required',
            'email'      => 'email|required|unique:customers,email',
            'password'   => 'min:6|required',
            'password_confirmation' => 'required|required_with:password|same:password',
        ];

        if (isset($data['is_social_login']) && $data['is_social_login']) {
            $data['password'] = $data['password_confirmation'] = rand(1,999999);

            $validationArray = array_merge($validationArray, [
                'phone' => 'string|required',
            ]);
        }
        
        $validator = \Validator::make($data, $validationArray);
                
        if ($validator->fails()) {
            $errorMessage = [];
            foreach ($validator->messages()->toArray() as $message) {
                $errorMessage[] = is_array($message) ? $message[0] : $message;
            }
            
            throw new CustomException(
                implode(" ,", $errorMessage),
                'Invalid Register Details.'
            );
        }
        
        try {
            $data['password'] = bcrypt($data['password']);
            $data['api_token'] = Str::random(80);

            if (core()->getConfigData('customer.settings.email.verification')) {
                $data['is_verified'] = 0;
            } else {
                $data['is_verified'] = 1;
            }
    
            $data['customer_group_id'] = $this->customerGroupRepository->findOneWhere(['code' => 'general'])->id;

            $verificationData['email'] = $data['email'];
            $verificationData['token'] = md5(uniqid(rand(), true));
            $data['token'] = $verificationData['token'];

            Event::dispatch('customer.registration.before');
    
            $customer = $this->customerRepository->create($data);
    
            Event::dispatch('customer.registration.after', $customer);

            if ( isset($customer->id)) {
                if (core()->getConfigData('customer.settings.email.verification')) {
                    try {
                        $configKey = 'emails.general.notifications.emails.general.notifications.verification';
                        if (core()->getConfigData($configKey)) {
                            Mail::queue(new VerificationEmail($verificationData));
                        }

                        return [
                            'status'    => true,
                            'success'   => trans('shop::app.customer.signup-form.success-verify')
                        ];
                    } catch (Exception $e) {
                        throw new Exception($e->getMessage());
                    }
                } else {
                    try {
                        $configCustomerKey = 'emails.general.notifications.emails.general.notifications.registration';
                        if (core()->getConfigData($configCustomerKey)) {
                            Mail::queue(new RegistrationEmail($data, 'customer'));
                        }

                        $configAdminKey = 'emails.general.notifications.emails.general.notifications.customer-registration-confirmation-mail-to-admin';
                        if (core()->getConfigData($configAdminKey)) {
                            Mail::queue(new RegistrationEmail(request()->all(), 'admin'));
                        }

                        $remember = isset($data['remember']) ? $data['remember'] : 0;
                    
                        if (! $jwtToken = JWTAuth::attempt([
                            'email'     => $data['email'],
                            'password'  => $data['password_confirmation'],
                        ], $remember)) {
                            throw new CustomException(
                                trans('shop::app.customer.login-form.invalid-creds'),
                                'Invalid Email and Password.'
                            );
                        }

                        $loginCustomer = bagisto_graphql()->guard($this->guard)->user();

                        if (
                            $loginCustomer->status == 0
                            || $loginCustomer->is_verified == 0
                            ) {
                            bagisto_graphql()->guard($this->guard)->logout();
                
                            throw new CustomException(
                                trans('shop::app.customer.login-form.not-activated'),
                                'Account Not Activated.'
                            );
                        }

                        return [
                            'status'        => true,
                            'success'       => trans('bagisto_graphql::app.shop.customer.success-login'),
                            'access_token'  => 'Bearer ' . $jwtToken,
                            'token_type'    => 'Bearer',
                            'expires_in'    => bagisto_graphql()->guard($this->guard)->factory()->getTTL() * 60,
                            'customer'      => $loginCustomer
                        ];
                    } catch (Exception $e) {
                        throw new CustomException(
                            $e->getMessage(),
                            'Customer Registration Email Failed.'
                        );
                    }
                }
            } else {
                return [
                    'status'    => false,
                    'success'   => trans('bagisto_graphql::app.shop.response.error-registration')
                ]; 
            }
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                'Customer Registration Failed.'
            );
        }
    }
}