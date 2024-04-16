<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Http\Controllers\Controller;
use Webkul\Customer\Rules\VatIdRule;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Customer\Repositories\CustomerAddressRepository;
use Webkul\GraphQLAPI\Validators\Customer\CustomException;

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
        if (! auth()->check()) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customerss.no-login-customer'));
        }

        $customer = auth()->guard()->user();

        $data = $args['input'];

        $data = array_merge($data, [
            'address' => implode(PHP_EOL, array_filter([$data['address']])),
        ]);

        $validator = Validator::make($data, [
            'company_name' => 'string',
            'first_name'   => 'string|required',
            'last_name'    => 'string|required',
            'address'      => 'string|required',
            'city'         => 'string|required',
            'postcode'     => 'required',
            'country'      => 'required|in:'.implode(',', (core()->countries()->pluck("code")->toArray())),
            'state'        => 'required|in:'.implode(',', (core()->states($data['country'])->pluck("code")->toArray())),
            'phone'        => 'required',
            'email'        => 'required|email',
            'vat_id'       => new VatIdRule(),
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        try {
            Event::dispatch('customer.address.create.before');

            $data = array_merge($data, [
                'customer_id' => $customer->id,
                'gender'      => $customer->gender,
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
        if (! auth()->check()) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customerss.no-login-customer'));
        }

        $customer = auth()->guard()->user();

        $data = $args['input'];

        $id = $args['id'];

        $data = array_merge($data, [
            'address' => implode(PHP_EOL, array_filter([$data['address']])),
        ]);

        $validator = Validator::make($data, [
            'company_name' => 'string',
            'first_name'   => 'string|required',
            'last_name'    => 'string|required',
            'address'      => 'string|required',
            'city'         => 'string|required',
            'postcode'     => 'required',
            'country'      => 'required|in:'.implode(',', (core()->countries()->pluck("code")->toArray())),
            'state'        => 'required|in:'.implode(',', (core()->states($data['country'])->pluck("code")->toArray())),
            'phone'        => 'required',
            'email'        => 'required|email',
            'vat_id'       => new VatIdRule(),
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        try {
            $customerAddress = $this->customerAddressRepository->findOneWhere([
                'id'          => $id,
                'customer_id' => $customer->id,
            ]);

            if (empty($customerAddress)) {
                throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.addresses.not-found'));
            }

            Event::dispatch('customer.address.update.before');

            $data = array_merge($data, [
                'gender' => $customer->gender,
            ]);

            $customerAddress = $this->customerAddressRepository->update($data, $id);

            Event::dispatch('customer.address.update.after', $customerAddress);

            return [
                'status'    => ! empty($customerAddress),
                'addresses' => $customerAddress,
                'message'   => trans('shop::app.customers.account.addresses.edit-success'),
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
        if (! auth()->check()) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customerss.no-login-customer'));
        }

        $customer = auth()->guard()->user();

        $id = $args['id'];

        try {
            $customerAddress = $this->customerAddressRepository->findOneWhere([
                'id'          => $id,
                'customer_id' => $customer->id,
            ]);

            if (empty($customerAddress)) {
                throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.addresses.not-found'));
            }

            Event::dispatch('customer.address.delete.before', $id);

            $this->customerAddressRepository->delete($id);

            Event::dispatch('customer.address.delete.after', $id);

            return [
                'status'  => true,
                'message' => trans('shop::app.customers.account.addresses.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage(),);
        }
    }
}
