<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Webkul\Core\Rules\PhoneNumber;
use App\Http\Controllers\Controller;
use Webkul\Customer\Rules\VatIdRule;
use Illuminate\Support\Facades\Event;
use Webkul\Core\Rules\AlphaNumericSpace;
use Illuminate\Support\Facades\Validator;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Customer\Repositories\CustomerRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Customer\Repositories\CustomerAddressRepository;

class AddressesMutation extends Controller
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
        if (! $customer = auth()->user()) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.no-login-customer'));
        }

        $data = $args['input'];
        
        $validator = Validator::make($data, [
            'company_name' => [new AlphaNumericSpace],
            'first_name'   => ['required', new AlphaNumericSpace],
            'last_name'    => ['required', new AlphaNumericSpace],
            'address'      => ['required', 'array', 'min:1'],
            'country'      => core()->isCountryRequired() ? ['required', new AlphaNumericSpace] : [new AlphaNumericSpace],
            'state'        => core()->isStateRequired() ? ['required', new AlphaNumericSpace] : [new AlphaNumericSpace],
            'city'         => ['required', 'string'],
            'postcode'     => core()->isPostCodeRequired() ? ['required', 'numeric'] : ['numeric'],
            'phone'        => ['required', new PhoneNumber],
            'vat_id'       => [new VatIdRule()],
            'email'        => ['required'],
        ]);

        bagisto_graphql()->checkValidatorFails($validator);
        
        try {
            Event::dispatch('customer.address.create.before');

            $data = array_merge($data, [
                'customer_id' => $customer->id,
                'address'     => implode(PHP_EOL, array_filter($data['address'])),
            ]);

            $customerAddress = $this->customerAddressRepository->create($data);

            Event::dispatch('customer.address.create.after', $customerAddress);

            return [
                'status'    => ! empty($customerAddress),
                'addresses' => $customerAddress,
                'message'   => trans('shop::app.customers.account.addresses.create-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
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
        if (! $customer = auth()->user()) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.no-login-customer'));
        }

        $id = $args['id'];
        
        if (! $customer->addresses->find($id)) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.addresses.not-found'));
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'company_name' => [new AlphaNumericSpace],
            'first_name'   => ['required', new AlphaNumericSpace],
            'last_name'    => ['required', new AlphaNumericSpace],
            'address'      => ['required', 'array', 'min:1'],
            'country'      => core()->isCountryRequired() ? ['required', new AlphaNumericSpace] : [new AlphaNumericSpace],
            'state'        => core()->isStateRequired() ? ['required', new AlphaNumericSpace] : [new AlphaNumericSpace],
            'city'         => ['required', 'string'],
            'postcode'     => core()->isPostCodeRequired() ? ['required', 'numeric'] : ['numeric'],
            'phone'        => ['required', new PhoneNumber],
            'vat_id'       => [new VatIdRule()],
            'email'        => ['required'],
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        try {
            Event::dispatch('customer.address.update.before');

            $data = array_merge($data, [
                'address' => implode(PHP_EOL, array_filter($data['address'])),
            ]);

            $customerAddress = $this->customerAddressRepository->update($data, $id);

            Event::dispatch('customer.address.update.after', $customerAddress);

            return [
                'status'    => ! empty($customerAddress),
                'addresses' => $customerAddress,
                'message'   => trans('bagisto_graphql::app.shop.customers.account.addresses.update-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
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
        if (! $customer = auth()->user()) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.no-login-customer'));
        }

        $id = $args['id'];

        try {
            if (! $customer->addresses->find($id)) {
                throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.addresses.not-found'));
            }

            Event::dispatch('customer.address.delete.before', $id);

            $this->customerAddressRepository->delete($id);

            Event::dispatch('customer.address.delete.after', $id);

            return [
                'status'  => true,
                'message' => trans('bagisto_graphql::app.shop.customers.account.addresses.delete-success'),
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
    public function setDefaultAddress($rootValue, array $args, GraphQLContext $context)
    {
        if (! $customer = auth()->user()) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.no-login-customer'));
        }

        $id = $args['id'];

        if (! $customer->addresses->find($id)) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.addresses.not-found'));
        }

        try {
            $customer->addresses->where('default_address', 1)->first()?->update(['default_address' => 0]);

            $customerAddress = $customer->addresses->find($id);

            $customerAddress->update(['default_address' => 1]);

            $customerAddress->success = trans('bagisto_graphql::app.admin.customers.addressess.default-update-success');

            return $customerAddress;
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
