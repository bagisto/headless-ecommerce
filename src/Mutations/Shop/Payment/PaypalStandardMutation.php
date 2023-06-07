<?php

declare(strict_types = 1);

namespace Webkul\GraphQLAPI\Mutations\Shop\Payment;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Webkul\Checkout\Facades\Cart;
use Webkul\Customer\Http\Controllers\Controller;
use Webkul\Paypal\Payment\Standard;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Paypal\Helpers\Ipn;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class PaypalStandardMutation extends Controller
{
    /**
     * Contains current guard
     *
     * @var string
     */
    protected string $guard;

    /**
     * Standard object
     *
     * @var \Webkul\Paypal\Payment\Standard;
     */
    protected Standard $paypal_standard;

    /**
     * Ipn Helper object
     *
     * @var \Webkul\Paypal\Helpers\Ipn;
     */
    protected Ipn $ipnHelper;

    /**
     * OrderRepository object
     *
     * @var \Webkul\Sales\Repositories\OrderRepository;
     */
    protected OrderRepository $orderRepository;

    /**
     * Create a new controller instance.
     *
     * @param \Webkul\Paypal\Payment\Standard   $paypal_standard
     * @param \Webkul\Paypal\Helpers\Ipn   $ipnHelper
     * @param \Webkul\Sales\Repositories\OrderRepository   $orderRepository
     *
     * @return void
     */
    public function __construct(
        Standard $paypal_standard,
        Ipn $ipnHelper,
        OrderRepository $orderRepository
    )   {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);

        $this->middleware('auth:'.$this->guard);

        $this->paypal_standard = $paypal_standard;

        $this->ipnHelper = $ipnHelper;

        $this->orderRepository = $orderRepository;
    }
    
    /**
     * Returns paypal url & form fields.
     *
     * @param                                                     $rootValue
     * @param array                                               $args
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext $context
     *
     * @return array
     * @throws \Exception
     */
    public function redirect($rootValue, array $args, GraphQLContext $context) : array
    {
        $data = $args;

        $company = app()->getInitializedCompany();
        if (!isset($company->id)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-comapny-header'));
        } else {
            $data['company_id'] = $company->id;
        }

        $validator = Validator::make($data, [
            'company_id' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $cart = Cart::getCart();

            if (!isset($cart->payment->method) || (isset($cart->payment->method) && $cart->payment->method != 'paypal_standard') ) {
                throw new Exception(trans('bagisto_graphql::app.shop.payment.invalid-request'));
            } else {
                if ($this->paypal_standard->getConfigData('active') && $this->paypal_standard->getConfigData('business_account')) {

                    $paypalFields = $this->paypal_standard->getFormFields();
                    foreach ($paypalFields as $index => $fieldValue) {
                        if ((Str::contains($index, 'item_number_') ||
                            Str::contains($index, 'item_name_') || 
                            Str::contains($index, 'quantity_') || 
                            Str::contains($index, 'amount_')) && $index != 'discount_amount_cart') {
                                unset($paypalFields[$index]);
                        }
                    }
                    
                    foreach ($this->paypal_standard->getCartItems() as $item) {
                        $paypalFields['paypal_item'][] = [
                            'item_number'   => $item->id,
                            'item_name'     => $item->name,
                            'quantity'      => $item->quantity,
                            'amount'        => $item->price
                        ];
                    }

                    if ($cart->selected_shipping_rate) {
                        $paypalFields['paypal_item'][] = [
                            'item_number'   => $cart->selected_shipping_rate->carrier_title,
                            'item_name'     => 'Shipping',
                            'quantity'      => 1,
                            'amount'        => $cart->selected_shipping_rate->price
                        ];
                    }
                    
                    $paypalFields['return'] = request()->server('PROTOCOL') . '://'.$company->domain.'/success';
                    $paypalFields['cancel_return'] = request()->server('PROTOCOL') . '://'.$company->domain.'/paypal/standard/cancel';
                    $paypalFields['notify_url'] = request()->server('PROTOCOL') . '://'.$company->domain.'/paypal/standard/ipn';
                    
                    return [
                        'success'               => trans('bagisto_graphql::app.shop.payment.paypal-standard.success-form-field', ['module_name'    => 'Paypal Standard']),
                        'cart'                  => $cart ? $cart : null,
                        'paypal_redirect_url'   => $this->paypal_standard->getPaypalUrl(),
                        'paypal_form_field'     => $paypalFields,
                    ];
                } else {
                    throw new Exception(trans('bagisto_graphql::app.shop.payment.paypal-standard.disable-module', ['module_name'    => 'Paypal Standard']));
                }
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Create Order and returns success url
     *
     * @param                                                     $rootValue
     * @param array                                               $args
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext $context
     *
     * @return array
     * @throws \Exception
     */
    public function success($rootValue, array $args, GraphQLContext $context) : array
    {
        $data = $args;

        $company = app()->getInitializedCompany();
        if (!isset($company->id)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-comapny-header'));
        } else {
            $data['company_id'] = $company->id;
        }

        $validator = Validator::make($data, [
            'company_id' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $cart = Cart::getCart();

            if ($cart && isset($cart->payment->method) && $cart->payment->method == 'paypal_standard') {
                $order = $this->orderRepository->create(Cart::prepareDataForOrder());

                Cart::deActivateCart();

                if ($order) {
                    return [
                        'success'       => trans('bagisto_graphql::app.shop.payment.paypal-standard.success-order-place'),
                        'order'         => $order,
                        'redirect_url'  => request()->server('PROTOCOL') . '://'.$company->domain.'/checkout/success',
                    ];
                } else {
                    throw new Exception(trans('bagisto_graphql::app.shop.payment.paypal-standard.enable-order-place'));
                }
            } else {
                throw new Exception(trans('bagisto_graphql::app.shop.payment.paypal-standard.enable-order-place'));
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Create Order and returns success url.
     *
     * @param                                                     $rootValue
     * @param array                                               $args
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext $context
     *
     * @return array
     * @throws \Exception
     */
    public function cancel($rootValue, array $args, GraphQLContext $context) : array
    {
        $data = $args;

        $company = app()->getInitializedCompany();
        if (!isset($company->id)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-comapny-header'));
        } else {
            $data['company_id'] = $company->id;
        }

        $validator = Validator::make($data, [
            'company_id' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }
        
        try {
            return [
                'success'       => trans('bagisto_graphql::app.shop.payment.paypal-standard.warning-order-cancel'),
                'redirect_url'  => request()->server('PROTOCOL') . '://'.$company->domain.'/checkout/cart',
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Paypal Ipn listener
     *
     * @param                                                     $rootValue
     * @param array                                               $args
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext $context
     *
     * @return array
     * @throws \Exception
     */
    public function ipn($rootValue, array $args, GraphQLContext $context) : array
    {
        $data = $args['input'];

        $company = app()->getInitializedCompany();
        if (!isset($company->id)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-comapny-header'));
        } else {
            $data['company_id'] = $company->id;
        }

        $validator = Validator::make($data, [
            'test_ipn'      => 'required|numeric',
            'invoice'       => 'required|numeric',
            'company_id'    => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $response = $this->ipnHelper->processIpn($data);

            if ( $response == false ) {
                throw new Exception(trans('bagisto_graphql::app.shop.payment.paypal-standard.warning-order-cancel'));
            }
            
            return [
                'success'       => trans('bagisto_graphql::app.shop.payment.paypal-standard.success-order-place'),
                'redirect_url'  => request()->server('PROTOCOL') . '://'.$company->domain.'/checkout/success',
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
