<?php

namespace Webkul\GraphQLAPI\Mutations\Customer;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Carbon\Carbon;
use Exception;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Customer\Repositories\CustomerGroupRepository;

class CustomerMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param \Webkul\Customer\Repositories\CustomerRepository  $customerRepository
     * @param  \Webkul\Customer\Repositories\CustomerGroupRepository  $customerGroupRepository
     * @return void
     */
    public function __construct(
        protected CustomerRepository $customerRepository,
        protected CustomerGroupRepository $customerGroupRepository
    )
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'first_name'        => 'string|required',
            'last_name'         => 'string|required',
            'gender'            => 'required',
            'email'             => 'required|unique:customers,email',
            'date_of_birth'     => 'string|before:today',
            'customer_group_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        $password = rand(100000, 10000000);

        $data['password'] = bcrypt($password);
        $data['is_verified'] = 1;
        $data['date_of_birth'] = ! empty($data['date_of_birth']) ? Carbon::createFromTimeString(str_replace('/', '-', $data['date_of_birth']) . '00:00:01')->format('Y-m-d') : '';

        try {
            Event::dispatch('customer.registration.before');

            $customer = $this->customerRepository->create($data);

            Event::dispatch('customer.registration.after', $customer);

            return $customer;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update($rootValue, array $args, GraphQLContext $context)
    {
        if (
            empty($args['id'])
            || empty($args['input'])
        ) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];
        $id = $args['id'];

        $validator = Validator::make($data, [
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
            $data['status'] = ! empty($data['status']) ? $data['status'] : 0;

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
        if (empty($args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $id = $args['id'];

        $customer = $this->customerRepository->findOrFail($id);

        try {
            if ($this->customerRepository->checkIfCustomerHasOrderPendingOrProcessing($customer)) {
                throw new Exception(trans('admin::app.response.order-pending', ['name' => 'Customer']));
            }

            Event::dispatch('customer.customer.delete.before', $id);

            $this->customerRepository->delete($id);

            Event::dispatch('customer.customer.delete.after', $id);

            return ['success' => trans('admin::app.customers.customers.delete-success', ['name' => 'Customer'])];
        } catch(\Exception $e) {
            throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Customer']));
        }
    }
}
