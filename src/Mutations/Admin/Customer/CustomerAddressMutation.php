<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Customer;

use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Core\Rules\PhoneNumber;
use Webkul\Core\Rules\PostCode;
use Webkul\Customer\Repositories\CustomerAddressRepository;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Customer\Rules\VatIdRule;
use Webkul\GraphQLAPI\Validators\CustomException;

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
    ) {}

    /**
     * Store a newly created resource in storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $args = array_merge($args, [
            'address' => implode(PHP_EOL, array_filter([$args['address']])),
        ]);

        bagisto_graphql()->validate($args, [
            'customer_id'  => ['numeric', 'required'],
            'company_name' => ['string'],
            'first_name'   => ['string', 'required'],
            'last_name'    => ['string', 'required'],
            'address'      => ['string', 'required'],
            'city'         => ['string', 'required'],
            'postcode'     => core()->isPostCodeRequired() ? ['required', new PostCode] : [new PostCode],
            'country'      => ['required', 'in:'.implode(',', (core()->countries()->pluck('code')->toArray()))],
            'state'        => ['required', 'in:'.implode(',', (core()->states($args['country'])->pluck('code')->toArray()))],
            'phone'        => ['required', new PhoneNumber],
            'email'        => ['required', 'email'],
            'vat_id'       => new VatIdRule,
        ]);

        $customer = $this->customerRepository->find($args['customer_id']);

        if (! $customer) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.customers.not-found'));
        }

        try {
            Event::dispatch('customer.addresses.create.before');

            $customerAddress = $this->customerAddressRepository->create($args);

            Event::dispatch('customer.addresses.create.after', $customerAddress);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.customers.addresses.create-success'),
                'address' => $customerAddress,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function update(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $args = array_merge($args, [
            'address' => implode(PHP_EOL, array_filter([$args['address']])),
        ]);

        bagisto_graphql()->validate($args, [
            'customer_id'  => ['numeric', 'required'],
            'company_name' => ['string'],
            'first_name'   => ['string', 'required'],
            'last_name'    => ['string', 'required'],
            'address'      => ['string', 'required'],
            'city'         => ['string', 'required'],
            'postcode'     => core()->isPostCodeRequired() ? ['required', new PostCode] : [new PostCode],
            'country'      => ['required', 'in:'.implode(',', (core()->countries()->pluck('code')->toArray()))],
            'state'        => ['required', 'in:'.implode(',', (core()->states($args['country'])->pluck('code')->toArray()))],
            'phone'        => ['required', new PhoneNumber],
            'email'        => ['required', 'email'],
            'vat_id'       => new VatIdRule,
        ]);

        $customer = $this->customerRepository->find($args['customer_id']);

        if (! $customer) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.customers.not-found'));
        }

        $customerAddress = $this->customerAddressRepository->find($args['id']);

        if (! $customerAddress) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.addresses.not-found'));
        }

        try {
            Event::dispatch('customer.addresses.update.before', $customerAddress->id);

            $customerAddress = $this->customerAddressRepository->update($args, $customerAddress->id);

            Event::dispatch('customer.addresses.update.after', $customerAddress);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.customers.addresses.update-success'),
                'address' => $customerAddress,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Update the default address.
     *
     * @return \Illuminate\Http\Response
     */
    public function setAsDefaultAddress(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $address = $this->customerAddressRepository->findOneWhere([
            'id'          => $args['id'],
            'customer_id' => $args['customer_id'],
        ]);

        if (! $address) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.addresses.not-found'));
        }

        if ($address->default_address) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.addresses.already-default'));
        }

        try {
            $this->customerAddressRepository->where([
                'customer_id'     => $args['customer_id'],
                'default_address' => 1,
            ])->update(['default_address' => 0]);

            $address->update(['default_address' => 1]);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.customers.addresses.default-update-success'),
                'address' => $address,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function delete(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $customerAddress = $this->customerAddressRepository->find($args['id']);

        if (! $customerAddress) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.addresses.not-found'));
        }

        try {
            Event::dispatch('customer.addresses.delete.before', $args['id']);

            $customerAddress->delete();

            Event::dispatch('customer.addresses.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.customers.addresses.delete-success'),
            ];

        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
