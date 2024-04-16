<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Customer;

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
            'address' => implode(PHP_EOL, array_filter([$data['address']])),
        ]);

        $validator = Validator::make($data, [
            'customer_id'  => 'numeric|required',
            'company_name' => 'string',
            'first_name'   => 'string|required',
            'last_name'    => 'string|required',
            'address'     => 'string|required',
            'city'         => 'string|required',
            'postcode'     => 'required',
            'country'      => 'required|in:'.implode(',', (core()->countries()->pluck("code")->toArray())),
            'state'        => 'required|in:'.implode(',', (core()->states($data['country'])->pluck("code")->toArray())),
            'phone'        => 'required',
            'email'        => 'required|email',
            'vat_id'       => new VatIdRule(),
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        $customer = $this->customerRepository->find($data['customer_id']);

        if (! $customer) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.customers.not-found'));
        }

        try {
            Event::dispatch('customer.address.create.before');

            $customerAddress = $this->customerAddressRepository->create($data);

            Event::dispatch('customer.address.create.after', $customerAddress);

            $customerAddress->success = trans('bagisto_graphql::app.admin.customers.addressess.create-success');

            return $customerAddress;
        } catch (\Exception $e) {
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
            'address' => implode(PHP_EOL, array_filter([$data['address']])),
        ]);

        $validator = Validator::make($data, [
            'company_name' => 'string',
            'first_name'   => 'string|required',
            'last_name'    => 'string|required',
            'address'     => 'string|required',
            'city'         => 'string|required',
            'postcode'     => 'required',
            'country'      => 'required|in:'.implode(',', (core()->countries()->pluck("code")->toArray())),
            'state'        => 'required|in:'.implode(',', (core()->states($data['country'])->pluck("code")->toArray())),
            'phone'        => 'required',
            'email'        => 'required|email',
            'vat_id'       => new VatIdRule(),
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        $customer = $this->customerRepository->find($data['customer_id']);

        if (! $customer) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.customers.not-found'));
        }

        $customerAddress = $this->customerAddressRepository->find($id);

        if (! $customerAddress) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.addressess.not-found'));
        }

        try {
            Event::dispatch('customer.address.update.before');

            $customerAddress = $this->customerAddressRepository->update($data, $id);

            Event::dispatch('customer.address.update.after', $customerAddress);

            $customerAddress->success = trans('bagisto_graphql::app.admin.customers.addressess.update-success');

            return $customerAddress;
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Update the default address.
     *
     * @return \Illuminate\Http\Response
     */
    public function setAsDefaultAddress($rootValue, array $args, GraphQLContext $context)
    {
        if (
            empty($args['id'])
            || empty($args['customer_id'])
        ) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $customerId = $args['customer_id'];

        $customer = $this->customerRepository->find($customerId);

        if (! $customer) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.customers.not-found'));
        }

        $id = $args['id'];

        $customerAddress = $this->customerAddressRepository->find($id);

        if (! $customerAddress) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.addressess.not-found'));
        }

        try {
            if ($default = $this->customerAddressRepository->findOneWhere(['customer_id' => $customerId, 'default_address' => 1])) {
                $default->update(['default_address' => 0]);
            }

            $customerAddress = $this->customerAddressRepository->findOneWhere([
                'id'              => $id,
                'customer_id'     => $customerId,
            ]);

            $customerAddress->update(['default_address' => 1]);

            $customerAddress->success = trans('bagisto_graphql::app.admin.customers.addressess.default-update-success');

            return $customerAddress;
        } catch (\Exception $e) {
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

        $customerAddress = $this->customerAddressRepository->find($id);

        if (! $customerAddress) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.addressess.not-found'));
        }

        try {
            Event::dispatch('customer.address.delete.before', $id);

            $this->customerAddressRepository->delete($id);

            Event::dispatch('customer.address.delete.after', $id);

            return ['success' => trans('bagisto_graphql::app.admin.customers.addressess.delete-success')];

        } catch(\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
