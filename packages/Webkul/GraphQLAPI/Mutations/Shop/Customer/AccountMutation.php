<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Exception;
use Hash;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Webkul\Customer\Http\Controllers\Controller;
use Webkul\Customer\Repositories\CustomerRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class AccountMutation extends Controller
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
     * Create a new controller instance.
     *
     * @param  \Webkul\Customer\Repositories\CustomerRepository  $customerRepository
     * @return void
     */
    public function __construct(
        CustomerRepository $customerRepository
    )
    {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);
        
        $this->middleware('auth:' . $this->guard);
        
        $this->customerRepository = $customerRepository;
    }

    /**
     * Returns a current customer data.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($rootValue, array $args , GraphQLContext $context)
    {
        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }
        
        if ( bagisto_graphql()->guard($this->guard)->check() ) {

            $customer = bagisto_graphql()->guard($this->guard)->user();

            $customer->success = trans('bagisto_graphql::app.shop.response.customer-details');
            return $customer;
        } else {
            return [
                'success'   => trans('bagisto_graphql::app.shop.customer.no-login-customer')
            ];
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
        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        if (! bagisto_graphql()->guard($this->guard)->check() ) {
            throw new Exception(trans('bagisto_graphql::app.shop.customer.no-login-customer'));
        }

        $customer = bagisto_graphql()->guard($this->guard)->user();

        $data = $args['input'];
        $isPasswordChanged = false;
        
        $validator = \Validator::make($data, [
            'first_name'            => 'string|required',
            'last_name'             => 'string|required',
            'gender'                => 'required',
            'date_of_birth'         => 'string|before:today',
            'email'                 => 'email|unique:customers,email,' . $customer->id,
            'oldpassword'           => 'required_with:password',
            'password'              => 'confirmed|min:6|required_with:oldpassword',
            'password_confirmation' => 'required_with:password',
        ]);
        
        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            if (isset ($data['date_of_birth']) && $data['date_of_birth'] == "") {
                unset($data['date_of_birth']);
            }

            $data['date_of_birth'] = (isset($data['date_of_birth']) && $data['date_of_birth']) ? Carbon::createFromTimeString(str_replace('/', '-', $data['date_of_birth']) . '00:00:01')->format('Y-m-d') : '';

            if (isset ($data['oldpassword'])) {
                if ( $data['oldpassword'] != "" || $data['oldpassword'] != null) {

                    if ( Hash::check($data['oldpassword'], $customer->password) ) {
                        $isPasswordChanged = true;
                        $data['password'] = bcrypt($data['password']);
                    } else {
                        throw new Exception(trans('shop::app.customer.account.profile.unmatch'));
                    }
                } else {
                    unset($data['password']);
                }
            }
    
            Event::dispatch('customer.update.before');
    
            if ($customer = $this->customerRepository->update($data, $customer->id)) {
    
                if ($isPasswordChanged) {
                    Event::dispatch('user.admin.update-password', $customer);
                }
    
                Event::dispatch('customer.update.after', $customer);
    
                $customer->success = trans('shop::app.customer.account.profile.edit-success');
    
                return $customer;
            } else {
                throw new Exception(trans('shop::app.customer.account.profile.edit-fail'));
            }
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
        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        if (! bagisto_graphql()->guard($this->guard)->check() ) {
            throw new Exception(trans('bagisto_graphql::app.shop.customer.no-login-customer'));
        }
        $data = $args['input'];

        $customer = bagisto_graphql()->guard($this->guard)->user();

        try {
            if (Hash::check($data['password'], $customer->password)) {
                $orders = $customer->all_orders->whereIn('status', ['pending', 'processing'])->first();

                if ($orders) {
                    throw new Exception(trans('admin::app.response.order-pending', ['name' => 'Customer']));
                } else {
                    $this->customerRepository->delete($customer->id);

                    return [
                        'status'    => true,
                        'success'   => trans('admin::app.response.delete-success', ['name' => 'Customer'])
                    ];
                }
            } else {
                throw new Exception(trans('shop::app.customer.account.address.delete.wrong-password'));
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}