<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Customer;

use Exception;
use Webkul\Customer\Rules\VatIdRule;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Customer\Repositories\CustomerRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Validators\Admin\CustomException;
use Webkul\Customer\Repositories\CustomerAddressRepository;

class CustomerAddressMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Customer\Repositories\CustomerRepository  $customerRepository
     * @param  \Webkul\Customer\Repositories\CustomerAddressRepository  $customerAddressRepository
     * @return void
     */
    public function __construct(
        protected CustomerRepository $customerRepository,
        protected CustomerAddressRepository $customerAddressRepository
    ) {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['input'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $data = $args['input'];

        $data = array_merge($data, [
            'address1' => implode(PHP_EOL, array_filter([$data['address1']])),
        ]);

        $validator = Validator::make($data, [
            'customer_id'  => 'numeric|required',
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
            throw new CustomException($validator->messages());
        }

        $customer = $this->customerRepository->find($data['customer_id']);

        if (! $customer) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.no-customer-found'));
        }

        try {
            Event::dispatch('customer.address.create.before');

            $customerAddress = $this->customerAddressRepository->create($data);

            Event::dispatch('customer.address.create.after', $customerAddress);

            return $customerAddress;
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
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
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
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
            throw new CustomException($validator->messages());
        }

        $customerAddress = $this->customerAddressRepository->findOrFail($id);

        try {
            Event::dispatch('customer.address.update.before');

            $customerAddress = $this->customerAddressRepository->update($data, $id);

            Event::dispatch('customer.address.update.after', $customerAddress);

            return $customerAddress;
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['id'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $id = $args['id'];

        $this->customerAddressRepository->findOrFail($id);

        try {
            Event::dispatch('customer.address.delete.before', $id);

            $this->customerAddressRepository->delete($id);

            Event::dispatch('customer.address.delete.after', $id);

            return ['success' => trans('bagisto_graphql::app.admin.customers.address-delete-success')];

        } catch(\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
