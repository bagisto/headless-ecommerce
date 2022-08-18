<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Exception;
use Webkul\GraphQLAPI\Validators\Customer\CustomException;
use Illuminate\Support\Facades\Event;
use Webkul\Customer\Rules\VatIdRule;
use Webkul\Customer\Http\Controllers\Controller;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Customer\Repositories\CustomerAddressRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\DB;

class AddressesMutation extends Controller
{
    /**
     * Contains current guard
     *
     * @var array
     */
    protected $guard;

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
    )
    {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);
        
        $this->middleware('auth:' . $this->guard);
    }

    /**
     * Returns a current customer's address detail.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function address($rootValue, array $args , GraphQLContext $context)
    {
        if (! isset($args['id']) || (isset($args['id']) && !$args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $id = $args['id'];
        
        if ( bagisto_graphql()->guard($this->guard)->check() ) {
            $customer = bagisto_graphql()->guard($this->guard)->user();

            $address = $this->customerAddressRepository->findOneWhere([
                'id'            => $id,
                'address_type'  => 'customer',
                'customer_id'   => $customer->id,
            ]);

            if ( isset($address->id) && $address->id ) {

                return $address;
            } else {
                throw new Exception(trans('bagisto_graphql::app.shop.response.not-found', ['name'   => 'Address']));
            }
        } else {
            throw new Exception(trans('bagisto_graphql::app.shop.customer.no-login-customer'));
        }
    }

    /**
     * Returns a current customer data.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addresses($rootValue, array $args , GraphQLContext $context)
    {        
        if ( bagisto_graphql()->guard($this->guard)->check() ) {
            $customer = bagisto_graphql()->guard($this->guard)->user();

            $addresses = DB::table('addresses as ca')
            ->select('ca.*')
            ->leftJoin('countries', 'ca.country', '=', 'countries.code')
            ->leftJoin('customers as c', 'ca.customer_id', '=', 'c.id')
            ->addSelect(DB::raw('' . DB::getTablePrefix() . 'countries.name as country_name'))
            ->where('c.id', $customer->id)->get();

            // $addresses = $this->customerAddressRepository->findWhere([
            //     'customer_id'   => $customer->id,
            // ]);
            
            return [
                'status'    => (count($addresses) > 0) ? true : false,
                'addresses' => $addresses,
                'message'   => (count($addresses) > 0) ? 'Success: Customer\'s addresses fetched successfully.' : trans('bagisto_graphql::app.shop.response.not-found', ['name'   => 'Address'])
            ];
        } else {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.customer.no-login-customer'),
                'Customer Not Login.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new CustomException(
                trans('bagisto_graphql::app.admin.response.error-invalid-parameter'),
                'Invalid request parameter.'
            );
        }

        if (! bagisto_graphql()->guard($this->guard)->check() ) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.customer.no-login-customer'),
                'Customer Not Login.'
            );
        }

        $data = $args['input'];

        $data = array_merge($data, [
            'address1' => implode(PHP_EOL, array_filter([$data['address1']])),
        ]);
        
        $validator = \Validator::make($data, [
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
            $errorMessage = [];
            foreach ($validator->messages()->toArray() as $field => $message) {
                $errorMessage[] = is_array($message) ? $message[0] : $message;
            }
            
            throw new CustomException(
                implode(" ,", $errorMessage),
                'Invalid Create Address Details.'
            );
        }

        $customer = bagisto_graphql()->guard($this->guard)->user();

        try {
            Event::dispatch('customer.address.create.before');
            
            $data['customer_id'] = $customer->id;
            $customerAddress = $this->customerAddressRepository->create($data);
    
            Event::dispatch('customer.address.create.after', $customerAddress);

            $addresses = $customer->addresses;
            
            return [
                'status'    => (isset($customerAddress->id)) ? true : false,
                'addresses' => $addresses,
                'message'   => ($customerAddress->id) ? 'Success: Customer\'s addresses saved successfully.' : trans('bagisto_graphql::app.shop.response.not-found', ['name'   => 'Address'])
            ];
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                'Address Create Failed.'
            );
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
            throw new CustomException(
                trans('bagisto_graphql::app.admin.response.error-invalid-parameter'),
                'Invalid request parameter.'
            );
        }

        if (! bagisto_graphql()->guard($this->guard)->check() ) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.customer.no-login-customer'),
                'Customer Not Login.'
            );
        }

        $data = $args['input'];
        $id = $args['id'];

        $data = array_merge($data, [
            'address1' => implode(PHP_EOL, array_filter([$data['address1']])),
        ]);
        
        $validator = \Validator::make($data, [
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
            $errorMessage = [];
            foreach ($validator->messages()->toArray() as $field => $message) {
                $errorMessage[] = is_array($message) ? $message[0] : $message;
            }
            
            throw new CustomException(
                implode(" ,", $errorMessage),
                'Invalid Update Address Details.'
            );
        }

        try {
            $customer = bagisto_graphql()->guard($this->guard)->user();

            $customerAddress = $this->customerAddressRepository->findOrFail($id);

            if ( isset($customerAddress->customer_id) && $customerAddress->customer_id !== $customer->id ) {
                throw new CustomException(
                    trans('bagisto_graphql::app.shop.customer.not-authorized'),
                    'You are not authorized to perform this action.'
                );
            }

            Event::dispatch('customer.address.update.before');

            $customerAddress = $this->customerAddressRepository->update($data, $id);

            Event::dispatch('customer.address.update.after', $customerAddress);
            
            return [
                'status'    => (isset($customerAddress->id)) ? true : false,
                'addresses' => $customer->addresses,
                'message'   => ($customerAddress->id) ? 'Success: Customer\'s address updated successfully.' : trans('bagisto_graphql::app.shop.response.not-found', ['name'   => 'Address'])
            ];
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                'Address Update Failed.'
            );
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
            throw new CustomException(
                trans('bagisto_graphql::app.admin.response.error-invalid-parameter'),
                'Invalid request parameter.'
            );
        }

        if (! bagisto_graphql()->guard($this->guard)->check() ) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.customer.no-login-customer'),
                'Customer Not Login.'
            );
        }

        $id = $args['id'];
        
        try {
            $customer = bagisto_graphql()->guard($this->guard)->user();

            $customerAddress = $this->customerAddressRepository->findOrFail($id);

            if ( isset($customerAddress->customer_id) && $customerAddress->customer_id !== $customer->id ) {
                throw new CustomException(
                    trans('bagisto_graphql::app.shop.customer.not-authorized'),
                    'You are not authorized to perform this action.'
                );
            }
        
            Event::dispatch('customer.address.delete.before', $id);

            $this->customerAddressRepository->delete($id);

            Event::dispatch('customer.address.delete.after', $id);
            
            return [
                'status'    => (isset($customerAddress->id)) ? true : false,
                'addresses' => $customer->addresses,
                'message'   => ($customerAddress->id) ? trans('admin::app.response.delete-success', ['name' => 'Customer\'s Address']) : trans('bagisto_graphql::app.shop.response.not-found', ['name'   => 'Address'])
            ];
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                'Address remove Failed.'
            );
        }
    }
}