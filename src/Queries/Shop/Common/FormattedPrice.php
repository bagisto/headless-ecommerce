<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Checkout\Repositories\CartItemRepository;
use Webkul\Checkout\Repositories\CartRepository;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class FormattedPrice extends BaseFilter
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CartRepository $cartRepository,
        protected CartItemRepository $cartItemRepository
    ) {}

    /**
     * Get formatted price for Cart data.
     *
     * @param  mixed  $rootValue
     * @return mixed
     */
    public function getCartPriceData($rootValue, array $args, GraphQLContext $context)
    {
        $cart = $this->cartRepository->find($rootValue->id);

        $cartCurrencyCode = $cart->cart_currency_code;

        return [
            'grand_total'                   => core()->formatPrice($cart->grand_total, $cartCurrencyCode),
            'base_grand_total'              => core()->formatBasePrice($cart->base_grand_total),
            'sub_total'                     => core()->formatPrice($cart->sub_total, $cartCurrencyCode),
            'base_sub_total'                => core()->formatBasePrice($cart->base_sub_total),
            'tax_total'                     => core()->formatPrice($cart->tax_total, $cartCurrencyCode),
            'base_tax_total'                => core()->formatBasePrice($cart->base_tax_total),
            'discount'                      => core()->formatPrice($cart->discount_amount, $cartCurrencyCode),
            'base_discount'                 => core()->formatBasePrice($cart->base_discount_amount),
            'discounted_sub_total'          => core()->formatPrice($cart->discounted_sub_total, $cartCurrencyCode),
            'base_discounted_sub_total'     => core()->formatBasePrice($cart->base_discounted_sub_total),
            'shipping_amount'               => core()->formatPrice($cart->shipping_amount, $cartCurrencyCode),
            'base_shipping_amount'          => core()->formatBasePrice($cart->base_shipping_amount),
            'shipping_amount_incl_tax'      => core()->formatPrice($cart->shipping_amount_incl_tax, $cartCurrencyCode),
            'base_shipping_amount_incl_tax' => core()->formatBasePrice($cart->base_shipping_amount_incl_tax),
            'sub_total_incl_tax'            => core()->formatPrice($cart->sub_total_incl_tax, $cartCurrencyCode),
            'base_sub_total_incl_tax'       => core()->formatBasePrice($cart->base_sub_total_incl_tax),
        ];
    }

    /**
     * Get formatted price for Cart data.
     *
     * @param  mixed  $rootValue
     * @return mixed
     */
    public function getCartItemPriceData($rootValue, array $args, GraphQLContext $context)
    {
        $cartItem = $this->cartItemRepository->find($rootValue->id);

        $cartCurrencyCode = $cartItem->cart->cart_currency_code;

        return [
            'price'                => core()->formatPrice($cartItem->price, $cartCurrencyCode),
            'base_price'           => core()->formatBasePrice($cartItem->base_price),
            'custom_price'         => core()->formatPrice($cartItem->custom_price, $cartCurrencyCode),
            'total'                => core()->formatPrice($cartItem->total, $cartCurrencyCode),
            'base_total'           => core()->formatBasePrice($cartItem->base_total),
            'tax_amount'           => core()->formatPrice($cartItem->tax_amount, $cartCurrencyCode),
            'base_tax_amount'      => core()->formatBasePrice($cartItem->base_tax_amount),
            'discount_amount'      => core()->formatPrice($cartItem->discount_amount, $cartCurrencyCode),
            'base_discount_amount' => core()->formatBasePrice($cartItem->base_discount_amount),
            'price_incl_tax'       => core()->formatPrice($cartItem->price_incl_tax, $cartCurrencyCode),
            'base_price_incl_tax'  => core()->formatBasePrice($cartItem->base_price_incl_tax),
            'total_incl_tax'       => core()->formatPrice($cartItem->total_incl_tax, $cartCurrencyCode),
            'base_total_incl_tax'  => core()->formatBasePrice($cartItem->base_total_incl_tax),
        ];
    }

    /**
     * Get formatted price for Cart Shipping Rate data.
     *
     * @param  mixed  $rootValue
     * @return mixed
     */
    public function getCartShippingRatePriceData($rootValue, array $args, GraphQLContext $context)
    {
        $shippingRate = $rootValue;

        $cartCurrencyCode = $shippingRate->shipping_address->cart->cart_currency_code;

        return [
            'price'                => core()->formatPrice($shippingRate->price, $cartCurrencyCode),
            'base_price'           => core()->formatBasePrice($shippingRate->base_price),
            'discount_amount'      => core()->formatPrice($shippingRate->discount_amount, $cartCurrencyCode),
            'base_discount_amount' => core()->formatBasePrice($shippingRate->base_discount_amount),
            'tax_amount'           => core()->formatPrice($shippingRate->tax_amount, $cartCurrencyCode),
            'base_tax_amount'      => core()->formatBasePrice($shippingRate->base_tax_amount),
            'price_incl_tax'       => core()->formatPrice($shippingRate->price_incl_tax, $cartCurrencyCode),
            'base_price_incl_tax'  => core()->formatBasePrice($shippingRate->base_price_incl_tax),
        ];
    }
}
