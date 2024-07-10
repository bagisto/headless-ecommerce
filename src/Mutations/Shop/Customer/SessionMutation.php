<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Webkul\Customer\Repositories\CustomerRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Validators\CustomException;

class SessionMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected CustomerRepository $customerRepository)
    {
        Auth::setDefaultDriver('api');
    }

    /**
     * Login user resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($rootValue, array $args , GraphQLContext $context)
    {
        $validator = Validator::make($args, [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        if (! $jwtToken = JWTAuth::attempt([
            'email'    => $args['email'],
            'password' => $args['password'],
        ], $args['remember'] ?? 0)) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.login.invalid-creds'));
        }

        try {
            $customer = auth()->user();

            if (! $customer->status) {
                $message = trans('bagisto_graphql::app.shop.customers.login.not-activated');
            }
            
            if (! $customer->is_verified) {
                $message = trans('bagisto_graphql::app.shop.customers.login.verify-first');
            }

            if (isset($message)) {
                request()->merge([
                    'token' => $jwtToken,
                ]);

                auth()->logout();

                throw new CustomException($message);
            }
            
            /**
             * Event passed to prepare cart after login.
             */
            Event::dispatch('customer.after.login', $customer);

            return [
                'status'       => true,
                'success'      => trans('bagisto_graphql::app.shop.customers.success-login'),
                'access_token' => "Bearer $jwtToken",
                'token_type'   => 'Bearer',
                'expires_in'   => auth()->factory()->getTTL() * 60,
                'customer'     => $this->customerRepository->find($customer->id),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        if (! auth()->check()) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.no-login-customer'));
        }

        $customer = auth()->user();

        auth()->logout();

        Event::dispatch('customer.after.logout', $customer->id);

        return [
            'status'  => true,
            'success' => trans('bagisto_graphql::app.shop.customers.success-logout'),
        ];
    }
}
