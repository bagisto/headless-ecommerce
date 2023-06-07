<?php

namespace Webkul\GraphQLAPI\Mutations\Customer;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Webkul\Customer\Rules\VatIdRule;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Customer\Repositories\CustomerAddressRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CustomerAddressMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Customer\Repositories\CustomerRepository         $customerRepository
     * @param  \Webkul\Customer\Repositories\CustomerAddressRepository  $customerAddressRepository
     * @return void
     */
    public function __construct(
        protected CustomerRepository $customerRepository,
        protected CustomerAddressRepository $customerAddressRepository
    )
    {
        $this->guard = 'admin-api';

        auth()->setDefaultDriver($this->guard);

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

        $data = $args['input'];

        $data = array_merge($data, [
            'address1' => implode(PHP_EOL, array_filter([$data['address1']])),
        ]);
        
        $validator = Validator::make($data, [
            'customer_id'   => 'numeric|required',
            'company_name'  => 'string',
            'address1'      => 'string|required',
            'country'       => 'string|required',
            'state'         => 'string|required',
            'city'          => 'string|required',
            'postcode'      => 'required',
            'phone'         => 'required',
            'vat_id'        => new VatIdRule(),
        ]);
        
        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        $customer = $this->customerRepository->find($data['customer_id']);

        if (! isset($customer->id) ) {
            throw new Exception(trans('bagisto_graphql::app.admin.customer.no-customer-found'));
        }

        try {
            Event::dispatch('customer.address.create.before');
    
            $customerAddress = $this->customerAddressRepository->create($data);
    
            Event::dispatch('customer.address.create.after', $customerAddress);

            return $customerAddress;
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

        $data = $args['input'];
        $id = $args['id'];

        $data = array_merge($data, [
            'address1' => implode(PHP_EOL, array_filter([$data['address1']])),
        ]);
        
        $validator = Validator::make($data, [
            'company_name' => 'string',
            'address1'     => 'string|required',
            'country'      => 'string|required',
            'state'        => 'string|required',
            'city'         => 'string|required',
            'postcode'     => 'required',
            'phone'        => 'required',
            'vat_id'       => new VatIdRule(),
        ]);
        
        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        $customerAddress = $this->customerAddressRepository->findOrFail($id);

        try {

            Event::dispatch('customer.address.update.before');

            $customerAddress = $this->customerAddressRepository->update($data, $id);

            Event::dispatch('customer.address.update.after', $customerAddress);

            return $customerAddress;
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

        $id = $args['id'];

        $customerAddress = $this->customerAddressRepository->findOrFail($id);

        try {
            Event::dispatch('customer.address.delete.before', $id);

            $this->customerAddressRepository->delete($id);

            Event::dispatch('customer.address.delete.after', $id);

            return ['success' => trans('admin::app.response.delete-success', ['name' => 'Customer\'s Address'])];

        } catch(\Exception $e) {
            throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Customer\'s Address']));
        }
    }
}
