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
        
        $validator = \Validator::make($data, [
            'first_name' => 'string|required',
            'last_name'  => 'string|required',
            'email'      => 'email|required|unique:customers,email',
            'password'   => 'min:6|required',
            'password_confirmation' => 'required|required_with:password|same:password',
        ]);
                
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
            $data['is_verified'] = (int) core()->getConfigData('customer.settings.email.verification') ? 0 : 1;
            $data['customer_group_id'] = $this->customerGroupRepository->findOneWhere(['code' => 'general'])->id;

            $verificationData['email'] = $data['email'];
            $verificationData['token'] = md5(uniqid(rand(), true));
            $data['token'] = $verificationData['token'];

            Event::dispatch('customer.registration.before');
    
            $customer = $this->customerRepository->create($data);
    
            Event::dispatch('customer.registration.after', $customer);

            if (! $customer) {
                return [
                    'status'    => false,
                    'success'   => trans('bagisto_graphql::app.shop.response.error-registration')
                ]; 
            }

            if (core()->getConfigData('customer.settings.email.verification')) {
                
                $configKey = 'emails.general.notifications.emails.general.notifications.verification';
                
                if (core()->getConfigData($configKey)) {
                    Mail::queue(new VerificationEmail($verificationData));
                }

                return [
                    'status'    => true,
                    'success'   => trans('shop::app.customer.signup-form.success-verify')
                ];
            } else {
                
                $configCustomerKey = 'emails.general.notifications.emails.general.notifications.registration';
                
                if (core()->getConfigData($configCustomerKey)) {
                    Mail::queue(new RegistrationEmail($data, 'customer'));
                }

                $configAdminKey = 'emails.general.notifications.emails.general.notifications.customer-registration-confirmation-mail-to-admin';
                
                if (core()->getConfigData($configAdminKey)) {
                    Mail::queue(new RegistrationEmail(request()->all(), 'admin'));
                }

                $remember = !empty($data['remember']) ? 1 : 0;

                if (! $jwtToken = JWTAuth::attempt([
                        'email'     => $data['email'],
                        'password'  => $data['password_confirmation'],
                    ], $remember)
                ) {
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
            }
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                'Customer Registration Failed.'
            );
        }
    }

    /**
     * Method to store user's sign up form data to DB.
     *
     * @return \Illuminate\Http\Response
     */
    public function socialSignUp($rootValue, array $args , GraphQLContext $context)
    {
        if (
            ! isset($args['input'])
            || (isset($args['input']) && !$args['input'])) {
            throw new CustomException(
                trans('bagisto_graphql::app.admin.response.error-invalid-parameter'),
                'Invalid request parameters.'
            );
        }
    
        $data = $args['input'];
        
        $validationArray = [
            'phone' => 'string|required',
        ];

        if (! empty($data['email'])) {
            $data['password'] = $data['password_confirmation'] = rand(1,999999);

            $validationArray = array_merge($validationArray, [
                'first_name'        => 'string|required',
                'last_name'         => 'string|required',
                'email'             => 'email|required|unique:customers,email',
                'password'          => 'min:6|required',
                'password_confirmation' => 'required|required_with:password|same:password',
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
                'Invalid Social SignUp Details.'
            );
        }
        
        try {
            if (empty($data['email'])) {
                return $this->loginCustomer($data);
            } else {
                $customer = $this->customerRepository->findOneByField('phone', $data['phone']);
                
                if ($customer && ($customer->email != $data['email'])) {
                    throw new CustomException(
                        trans('bagisto_graphql::app.shop.response.warning-num-already-used', ['phone' => $data['phone']]),
                        'Invalid request parameters.'
                    );
                }
            }

            $token  = md5(uniqid(rand(), true));
            
            $data   = array_merge($data, [
                'password'          => bcrypt($data['password']),
                'api_token'         => Str::random(80),
                'is_verified'       => core()->getConfigData('customer.settings.email.verification') ? 0 : 1,
                'customer_group_id' => $this->customerGroupRepository->findOneWhere(['code' => 'general'])->id,
                'token'             => $token,
            ]);

            $verificationData['email'] = $data['email'];
            $verificationData['token'] = $token;

            Event::dispatch('customer.registration.before');
    
            $customer = $this->customerRepository->create($data);
    
            Event::dispatch('customer.registration.after', $customer);

            if ($customer) {
                try {
                    $configCustomerKey = 'emails.general.notifications.emails.general.notifications.registration';
                    if (core()->getConfigData($configCustomerKey)) {
                        Mail::queue(new RegistrationEmail($data, 'customer'));
                    }

                    $configAdminKey = 'emails.general.notifications.emails.general.notifications.customer-registration-confirmation-mail-to-admin';
                    if (core()->getConfigData($configAdminKey)) {
                        Mail::queue(new RegistrationEmail(request()->all(), 'admin'));
                    }

                    return $this->loginCustomer($data);
                } catch (Exception $e) {
                    throw new CustomException(
                        $e->getMessage(),
                        'Customer Registration Email Failed.'
                    );
                }
            }
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                'Customer Registration Failed.'
            );
        }
    }

    public function loginCustomer($data)
    {
        $jwtToken = null;
        if (empty($data['email'])) {
            $customer = $this->customerRepository->findOneByField('phone', $data['phone']);
            
            if ($customer) {
                $jwtToken = JWTAuth::fromUser($customer);

                auth()->guard($this->guard)->login($customer, true);
            } else {
                return [
                    'status'    => false,
                    'success'   => trans('bagisto_graphql::app.shop.customer.not-exists'), 
                ];
            }
        } else {
            $remember = isset($data['remember']) ? $data['remember'] : 0;

            $jwtToken = JWTAuth::attempt([
                'email'     => $data['email'],
                'password'  => $data['password_confirmation'],
            ], $remember);
        }
                    
        if (! $jwtToken) {
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

        /**
         * Event passed to prepare cart after login.
         */
        Event::dispatch('customer.after.login', $loginCustomer->email);

        return [
            'status'        => true,
            'success'       => trans('bagisto_graphql::app.shop.customer.success-login'),
            'access_token'  => 'Bearer ' . $jwtToken,
            'token_type'    => 'Bearer',
            'expires_in'    => bagisto_graphql()->guard($this->guard)->factory()->getTTL() * 60,
            'customer'      => $loginCustomer
        ];
    }
}