<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Webkul\Customer\Repositories\CustomerRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Validators\Customer\CustomException;

class SessionMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected CustomerRepository $customerRepository)
    {
        auth()->setDefaultDriver('api');
    }

    /**
     * Login user resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($rootValue, array $args , GraphQLContext $context)
    {
        if (empty($args['input'])) {
            throw new CustomException(trans('bagisto_graphql::app.shop.response.error.invalid-parameter'));
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        if (! $jwtToken = JWTAuth::attempt([
            'email'    => $data['email'],
            'password' => $data['password'],
        ], $data['remember'] ?? 0)) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.login-form.invalid-creds'));
        }

        try {
            $customer = auth()->user();

            request()->merge([
                'token' => $jwtToken,
            ]);

            if (! $customer->status) {
                auth()->logout();

                throw new CustomException(trans('shop::app.customers.login-form.not-activated'));
            }

            if (! $customer->is_verified) {
                auth()->logout();

                throw new CustomException(trans('shop::app.customers.login-form.verify-first'));
            }

            /**
             * Event passed to prepare cart after login.
             */
            Event::dispatch('customer.after.login', $data['email']);

            return [
                'status'       => true,
                'success'      => trans('bagisto_graphql::app.shop.customers.success-login'),
                'access_token' => 'Bearer '.$jwtToken,
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
        if (auth()->check()) {
            $customer = auth()->user();

            auth()->logout();

            Event::dispatch('customer.after.logout', $customer->id);

            return [
                'status'  => true,
                'success' => trans('bagisto_graphql::app.shop.customers.success-logout'),
            ];
        }

        throw new CustomException(trans('bagisto_graphql::app.shop.customers.no-login-customer'));
    }
}
