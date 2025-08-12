<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Core\Rules\PhoneNumber;
use Webkul\Core\Rules\PostCode;
use Webkul\Customer\Repositories\CustomerAddressRepository;
use Webkul\Customer\Rules\VatIdRule;
use Webkul\GraphQLAPI\Validators\CustomException;

class AddressesMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected CustomerAddressRepository $customerAddressRepository) {}

    /**
     * Store a newly created resource in storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $customer = bagisto_graphql()->authorize();

        bagisto_graphql()->validate($args, [
            'company_name' => ['nullable'],
            'first_name'   => ['required'],
            'last_name'    => ['required'],
            'address'      => ['required', 'array', 'min:1'],
            'address.*'    => ['required', 'string'],
            'country'      => core()->isCountryRequired() ? ['required'] : ['nullable'],
            'state'        => core()->isStateRequired() ? ['required'] : ['nullable'],
            'city'         => ['required', 'string'],
            'postcode'     => core()->isPostCodeRequired() ? ['required', new PostCode] : [new PostCode],
            'phone'        => ['required', new PhoneNumber],
            'vat_id'       => [new VatIdRule],
            'email'        => ['required', 'email'],
        ]);

        try {
            Event::dispatch('customer.addresses.create.before');

            $args = array_merge($args, [
                'customer_id' => $customer->id,
                'address'     => implode(PHP_EOL, array_filter($args['address'])),
            ]);

            $customerAddress = $this->customerAddressRepository->create($args);

            Event::dispatch('customer.addresses.create.after', $customerAddress);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.shop.customers.account.addresses.create-success'),
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
        $customer = bagisto_graphql()->authorize();

        if (! $customer->addresses->find($args['id'])) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.addresses.not-found'));
        }

        bagisto_graphql()->validate($args, [
            'company_name' => ['nullable'],
            'first_name'   => ['required'],
            'last_name'    => ['required'],
            'address'      => ['required', 'array', 'min:1'],
            'country'      => core()->isCountryRequired() ? ['required'] : ['nullable'],
            'state'        => core()->isStateRequired() ? ['required'] : ['nullable'],
            'city'         => ['required', 'string'],
            'postcode'     => core()->isPostCodeRequired() ? ['required', new PostCode] : [new PostCode],
            'phone'        => ['required', new PhoneNumber],
            'vat_id'       => [new VatIdRule],
            'email'        => ['required', 'email'],
        ]);

        try {
            Event::dispatch('customer.addresses.update.before');

            $args = array_merge($args, [
                'address' => implode(PHP_EOL, array_filter($args['address'])),
            ]);

            $customerAddress = $this->customerAddressRepository->update($args, $args['id']);

            Event::dispatch('customer.addresses.update.after', $customerAddress);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.shop.customers.account.addresses.update-success'),
                'address' => $customerAddress,
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
        $customer = bagisto_graphql()->authorize();

        try {
            if (! $customer->addresses->find($args['id'])) {
                throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.addresses.not-found'));
            }

            Event::dispatch('customer.addresses.delete.before', $args['id']);

            $this->customerAddressRepository->delete($args['id']);

            Event::dispatch('customer.addresses.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.shop.customers.account.addresses.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Update the default address.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function setDefaultAddress(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $customer = bagisto_graphql()->authorize();

        if (! $address = $customer->addresses->find($args['id'])) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.addresses.not-found'));
        }

        if ($address->default_address) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.addresses.already-default'));
        }

        try {
            $customer->addresses->where('default_address', 1)->first()?->update(['default_address' => 0]);

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
}
