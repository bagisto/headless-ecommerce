<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Event;
use Webkul\Customer\Rules\VatIdRule;
use Webkul\Customer\Http\Controllers\Controller;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Customer\Repositories\CustomerAddressRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class AddressesMutation extends Controller
{
    /**
     * Contains current guard
     *
     * @var array
     */
    protected $guard;

    /**
     * CustomerRepository object
     *
     * @var \Webkul\Customer\Repositories\CustomerRepository
     */
    protected $customerRepository;

    /**
     * CustomerAddressRepository object
     *
     * @var \Webkul\Customer\Repositories\CustomerAddressRepository
     */
    protected $customerAddressRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Customer\Repositories\CustomerRepository  $customerRepository
     * @param  \Webkul\Customer\Repositories\CustomerAddressRepository  $customerAddressRepository
     * @return void
     */
    public function __construct(
        CustomerRepository $customerRepository,
        CustomerAddressRepository $customerAddressRepository
    )
    {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);
        
        $this->middleware('auth:' . $this->guard);
        
        $this->customerRepository = $customerRepository;
        
        $this->customerAddressRepository = $customerAddressRepository;
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

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
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
        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }
        
        if ( bagisto_graphql()->guard($this->guard)->check() ) {
            $customer = bagisto_graphql()->guard($this->guard)->user();
            
            $addresses = $customer->addresses;

            if ( count($addresses) ) {
                return $addresses;
            } else {
                throw new Exception(trans('bagisto_graphql::app.shop.response.not-found', ['name'   => 'Address']));
            }
        } else {
            throw new Exception(trans('bagisto_graphql::app.shop.customer.no-login-customer'));
        }
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

        if (! bagisto_graphql()->guard($this->guard)->check() ) {
            throw new Exception(trans('bagisto_graphql::app.shop.customer.no-login-customer'));
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
            throw new Exception($validator->messages());
        }

        $data['customer_id'] = bagisto_graphql()->guard($this->guard)->user()->id;

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

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        if (! bagisto_graphql()->guard($this->guard)->check() ) {
            throw new Exception(trans('bagisto_graphql::app.shop.customer.no-login-customer'));
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
            throw new Exception($validator->messages());
        }

        try {
            $customer_id = bagisto_graphql()->guard($this->guard)->user()->id;

            $customerAddress = $this->customerAddressRepository->findOrFail($id);

            if ( isset($customerAddress->customer_id) && $customerAddress->customer_id !== $customer_id ) {
                throw new Exception(trans('bagisto_graphql::app.shop.customer.not-authorized'));
            }

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

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        if (! bagisto_graphql()->guard($this->guard)->check() ) {
            throw new Exception(trans('bagisto_graphql::app.shop.customer.no-login-customer'));
        }

        $id = $args['id'];
        
        try {
            $customer_id = bagisto_graphql()->guard($this->guard)->user()->id;

            $customerAddress = $this->customerAddressRepository->findOrFail($id);

            if ( isset($customerAddress->customer_id) && $customerAddress->customer_id !== $customer_id ) {
                throw new Exception(trans('bagisto_graphql::app.shop.customer.not-authorized'));
            }
        
            Event::dispatch('customer.address.delete.before', $id);

            $this->customerAddressRepository->delete($id);

            Event::dispatch('customer.address.delete.after', $id);

            return ['success' => trans('admin::app.response.delete-success', ['name' => 'Customer\'s Address'])];
        } catch(\Exception $e) {
            throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Customer\'s Address']));
        }
    }
}