<?php

namespace Webkul\GraphQLAPI\Mutations\Customer;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Customer\Repositories\CustomerGroupRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Mail;
use Webkul\Admin\Mail\NewCustomerNotification;

class CustomerMutation extends Controller
{
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
     * @param \Webkul\Customer\Repositories\CustomerRepository  $customerRepository
     * @param  \Webkul\Customer\Repositories\CustomerGroupRepository  $customerGroupRepository
     * @return void
     */
    public function __construct(
        CustomerRepository $customerRepository,
        CustomerGroupRepository $customerGroupRepository
    )
    {
        $this->guard = 'admin-api';

        auth()->setDefaultDriver($this->guard);
        
        $this->middleware('auth:' . $this->guard);
        
        $this->customerRepository = $customerRepository;
        
        $this->customerGroupRepository = $customerGroupRepository;

        $this->_config = request('_config');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        $data = $args['input'];

        $validator = \Validator::make($data, [
            'first_name'        => 'string|required',
            'last_name'         => 'string|required',
            'gender'            => 'required',
            'email'             => 'required|unique:customers,email',
            'date_of_birth'     => 'date|before:today',
            'customer_group_id' => 'required|numeric',
        ]);
        
        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        $password = rand(100000, 10000000);

        $data['password'] = bcrypt($password);

        $data['is_verified'] = 1;

        try {
            Event::dispatch('customer.registration.before');
    
            $customer = $this->customerRepository->create($data);
    
            Event::dispatch('customer.registration.after', $customer);
            
            $configKey = 'emails.general.notifications.emails.general.notifications.customer';
            if (core()->getConfigData($configKey)) {
                Mail::queue(new NewCustomerNotification($customer, $password));
            }
            
            return $customer;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['id']) || !isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        $data = $args['input'];
        $id = $args['id'];
        
        $validator = \Validator::make($data, [
            'first_name'        => 'string|required',
            'last_name'         => 'string|required',
            'gender'            => 'required',
            'email'             => 'required|unique:customers,email,' . $id,
            'date_of_birth'     => 'date|before:today',
            'customer_group_id' => 'required|numeric',
        ]);
        
        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $data['status'] = ! isset($data['status']) ? 0 : 1;

            Event::dispatch('customer.customer.update.before');

            $customer = $this->customerRepository->update($data, $id);

            Event::dispatch('customer.customer.update.after', $customer);

            return $customer;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['id']) || (isset($args['id']) && !$args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        $id = $args['id'];

        $customer = $this->customerRepository->findOrFail($id);

        try {

            if (! $this->customerRepository->checkIfCustomerHasOrderPendingOrProcessing($customer)) {
                Event::dispatch('customer.customer.delete.before', $id);

                $this->customerRepository->delete($id);

                Event::dispatch('customer.customer.delete.after', $id);

                return ['success' => trans('admin::app.response.delete-success', ['name' => 'Customer'])];
            
            } else {
                throw new Exception(trans('admin::app.response.order-pending', ['name' => 'Customer']));

            }
        } catch(\Exception $e) {
            throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Customer']));
        }
    }
}
