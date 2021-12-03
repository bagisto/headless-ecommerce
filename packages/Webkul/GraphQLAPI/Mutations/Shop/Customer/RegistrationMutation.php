<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Exception;
use Illuminate\Http\JsonResponse;
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
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
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
            throw new Exception($validator->messages());
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

                        return [
                            'status'    => true,
                            'success'   => trans('shop::app.customer.signup-form.success')
                        ];
                    } catch (Exception $e) {
                        throw new Exception($e->getMessage());
                    }
                }
            } else {
                return [
                    'status'    => false,
                    'success'   => trans('bagisto_graphql::app.shop.response.error-registration')
                ]; 
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}