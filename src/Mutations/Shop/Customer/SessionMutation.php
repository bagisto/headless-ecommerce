<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Exception;
use JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Webkul\Customer\Http\Controllers\Controller;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Validators\Customer\CustomException;

class SessionMutation extends Controller
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
     * @return void
     */
    public function __construct()
    {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);
        
        $this->middleware('auth:' . $this->guard, ['except' => ['login']]);
    }

    /**
     * Login user resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($rootValue, array $args , GraphQLContext $context)
    {
        if (! isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new CustomException(
                trans('bagisto_graphql::app.admin.response.error-invalid-parameter'),
                'Invalid request parameters.'
            );
        }

        $data = $args['input'];
        
        $validator = Validator::make($data, [
            'email'     => 'required|email',
            'password'  => 'required',
        ]);
        
        if ($validator->fails()) {
            throw new CustomException(
                $validator->messages(),
                'Invalid Login Details.'
            );
        }

        $remember = isset($data['remember']) ? $data['remember'] : 0;
    
        if (! $jwtToken = JWTAuth::attempt([
            'email'     => $data['email'],
            'password'  => $data['password'],
        ], $remember)) {
            throw new CustomException(
                trans('shop::app.customer.login-form.invalid-creds'),
                'Invalid Email and Password.'
            );
        }
        
        try {
            if (bagisto_graphql()->guard($this->guard)->user()->status == 0) {
                bagisto_graphql()->guard($this->guard)->logout();
    
                throw new CustomException(
                    trans('shop::app.customer.login-form.not-activated'),
                    'Account Not Activated.'
                );
            }
    
            if (bagisto_graphql()->guard($this->guard)->user()->is_verified == 0) {
                bagisto_graphql()->guard($this->guard)->logout();
                
                throw new CustomException(
                    trans('shop::app.customer.login-form.verify-first'),
                    'Need email varification.'
                );
            }

            /**
             * Event passed to prepare cart after login.
             */
            Event::dispatch('customer.after.login', $data['email']);
            
            return [
                'status'        => true,
                'success'       => trans('bagisto_graphql::app.shop.customer.success-login'),
                'access_token'  => 'Bearer ' . $jwtToken,
                'token_type'    => 'Bearer',
                'expires_in'    => bagisto_graphql()->guard($this->guard)->factory()->getTTL() * 60,
                'customer'      => bagisto_graphql()->guard($this->guard)->user()
            ];
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                'Customer Login Failed.'
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new CustomException(
                trans('bagisto_graphql::app.admin.response.invalid-header'),
                'Invalid request header parameters.'
            );
        }

        if ( bagisto_graphql()->guard($this->guard)->check() ) {
            $customer = bagisto_graphql()->guard($this->guard)->user();
            bagisto_graphql()->guard($this->guard)->logout();

            Event::dispatch('customer.after.logout', $customer->id);
            
            return [
                'status'    => true,
                'success'   => trans('bagisto_graphql::app.shop.customer.success-logout'),
            ]; 
        } else {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.customer.no-login-user'),
                'Customer Login Failed.'
            );
        }
    }
}