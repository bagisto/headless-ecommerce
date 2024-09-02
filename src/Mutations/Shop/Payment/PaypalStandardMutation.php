<?php

declare(strict_types=1);

namespace Webkul\GraphQLAPI\Mutations\Shop\Payment;

use Illuminate\Support\Str;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Checkout\Facades\Cart;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Paypal\Helpers\Ipn as IpnHelper;
use Webkul\Paypal\Payment\Standard;
use Webkul\Sales\Repositories\OrderRepository;

class PaypalStandardMutation
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected Standard $paypalStandard,
        protected IpnHelper $ipnHelper,
        protected OrderRepository $orderRepository
    ) {}

    /**
     * Returns paypal url & form fields.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function redirect(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $company = app()->getInitializedCompany();

        if (! isset($company->id)) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.invalid-comapny-header'));
        } else {
            $args['company_id'] = $company->id;
        }

        bagisto_graphql()->validate($args, [
            'company_id' => 'required|numeric|min:1',
        ]);

        try {
            $cart = Cart::getCart();

            if (
                ! isset($cart->payment->method)
                || (
                    isset($cart->payment->method)
                    && $cart->payment->method != 'paypal_standard'
                )
            ) {
                throw new CustomException(trans('bagisto_graphql::app.shop.payment.invalid-request'));
            } else {
                if (
                    $this->paypalStandard->getConfigData('active')
                    && $this->paypalStandard->getConfigData('business_account')
                ) {
                    $paypalFields = $this->paypalStandard->getFormFields();

                    foreach ($paypalFields as $index => $fieldValue) {
                        if (
                            (
                                Str::contains($index, 'item_number_')
                                || Str::contains($index, 'item_name_')
                                || Str::contains($index, 'quantity_')
                                || Str::contains($index, 'amount_')
                            ) && $index != 'discount_amount_cart'
                        ) {
                            unset($paypalFields[$index]);
                        }
                    }

                    foreach ($this->paypalStandard->getCartItems() as $item) {
                        $paypalFields['paypal_item'][] = [
                            'item_number'   => $item->id,
                            'item_name'     => $item->name,
                            'quantity'      => $item->quantity,
                            'amount'        => $item->price,
                        ];
                    }

                    if ($cart->selected_shipping_rate) {
                        $paypalFields['paypal_item'][] = [
                            'item_number' => $cart->selected_shipping_rate->carrier_title,
                            'item_name'   => 'Shipping',
                            'quantity'    => 1,
                            'amount'      => $cart->selected_shipping_rate->price,
                        ];
                    }

                    $paypalFields['return'] = request()->server('PROTOCOL').'://'.$company->domain.'/success';

                    $paypalFields['cancel_return'] = request()->server('PROTOCOL').'://'.$company->domain.'/paypal/standard/cancel';

                    $paypalFields['notify_url'] = request()->server('PROTOCOL').'://'.$company->domain.'/paypal/standard/ipn';

                    return [
                        'success'             => true,
                        'message'             => trans('bagisto_graphql::app.shop.payment.paypal-standard.success-form-field', ['module_name' => 'Paypal Standard']),
                        'cart'                => $cart,
                        'paypal_redirect_url' => $this->paypalStandard->getPaypalUrl(),
                        'paypal_form_field'   => $paypalFields,
                    ];
                } else {
                    throw new CustomException(trans('bagisto_graphql::app.shop.payment.paypal-standard.disable-module', ['module_name' => 'Paypal Standard']));
                }
            }
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Create Order and returns success url
     *
     * @return array
     *
     * @throws CustomException
     */
    public function success(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $company = app()->getInitializedCompany();

        if (! isset($company->id)) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.invalid-comapny-header'));
        } else {
            $args['company_id'] = $company->id;
        }

        bagisto_graphql()->validate($args, [
            'company_id' => 'required|numeric|min:1',
        ]);

        try {
            $cart = Cart::getCart();

            if (
                $cart
                && isset($cart->payment->method)
                && $cart->payment->method == 'paypal_standard'
            ) {
                $order = $this->orderRepository->create(Cart::prepareDataForOrder());

                Cart::deActivateCart();

                if ($order) {
                    return [
                        'success'      => true,
                        'message'      => trans('bagisto_graphql::app.shop.payment.paypal-standard.success-order-place'),
                        'order'        => $order,
                        'redirect_url' => request()->server('PROTOCOL').'://'.$company->domain.'/checkout/success',
                    ];
                } else {
                    throw new CustomException(trans('bagisto_graphql::app.shop.payment.paypal-standard.enable-order-place'));
                }
            } else {
                throw new CustomException(trans('bagisto_graphql::app.shop.payment.paypal-standard.enable-order-place'));
            }
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Create Order and returns success url
     *
     * @return array
     *
     * @throws CustomException
     */
    public function cancel(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $company = app()->getInitializedCompany();

        if (! isset($company->id)) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.invalid-comapny-header'));
        } else {
            $args['company_id'] = $company->id;
        }

        bagisto_graphql()->validate($args, [
            'company_id' => 'required|numeric|min:1',
        ]);

        try {
            return [
                'success'      => true,
                'message'      => trans('bagisto_graphql::app.shop.payment.paypal-standard.warning-order-cancel'),
                'redirect_url' => request()->server('PROTOCOL').'://'.$company->domain.'/checkout/cart',
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Paypal Ipn listener
     *
     * @return array
     *
     * @throws CustomException
     */
    public function ipn(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $company = app()->getInitializedCompany();

        if (! isset($company->id)) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.invalid-comapny-header'));
        } else {
            $args['company_id'] = $company->id;
        }

        bagisto_graphql()->validate($args, [
            'test_ipn'      => 'required|numeric',
            'invoice'       => 'required|numeric',
            'company_id'    => 'required|numeric|min:1',
        ]);

        try {
            $response = $this->ipnHelper->processIpn($args);

            if ($response == false) {
                throw new CustomException(trans('bagisto_graphql::app.shop.payment.paypal-standard.warning-order-cancel'));
            }

            return [
                'success'      => true,
                'message'      => trans('bagisto_graphql::app.shop.payment.paypal-standard.success-order-place'),
                'redirect_url' => request()->server('PROTOCOL').'://'.$company->domain.'/checkout/success',
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
