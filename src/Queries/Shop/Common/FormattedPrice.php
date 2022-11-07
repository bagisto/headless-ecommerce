<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Queries\BaseFilter;
use Webkul\Checkout\Repositories\CartRepository;
use Webkul\Checkout\Repositories\CartItemRepository;

class FormattedPrice extends BaseFilter
{
    /**
     * Cart repository instance.
     *
     * @var \Webkul\Checkout\Repositories\CartRepository
     */
    protected $cartRepository;

    /**
     * CartItem repository instance.
     *
     * @var \Webkul\Checkout\Repositories\CartItemRepository
     */
    protected $cartItemRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Checkout\Repositories\CartRepository  $cartRepository
     * @param  \Webkul\Checkout\Repositories\CartItemRepository  $cartItemRepository
     * @return void
     */
    public function __construct(
        CartRepository $cartRepository,
        CartItemRepository $cartItemRepository
    ) {
        $this->cartRepository = $cartRepository;

        $this->cartItemRepository = $cartItemRepository;

        $this->_config = request('_config');
    }

    /**
     * Get formatted price for Cart data.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return mixed
     */
    public function getCartPriceData($rootValue, array $args, GraphQLContext $context)
    {
        $cart = $this->cartRepository->find($rootValue->id);

        return [
            'grand_total' => core()->formatPrice($cart->grand_total, $cart->cart_currency_code),
            'base_grand_total' => core()->formatBasePrice($cart->base_grand_total),
            'sub_total' => core()->formatPrice($cart->sub_total, $cart->cart_currency_code),
            'base_sub_total' => core()->formatBasePrice($cart->base_sub_total),
            'tax_total' => core()->formatPrice($cart->tax_total, $cart->cart_currency_code),
            'base_tax_total' => core()->formatBasePrice($cart->base_tax_total),
            'discount' => core()->formatPrice($cart->discount_amount, $cart->cart_currency_code),
            'base_discount' => core()->formatBasePrice($cart->base_discount_amount),
            'discounted_sub_total' => core()->formatPrice($cart->discounted_sub_total, $cart->cart_currency_code),
            'base_discounted_sub_total' => core()->formatBasePrice($cart->base_discounted_sub_total),
        ];
    }

    /**
     * Get formatted price for Cart data.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return mixed
     */
    public function getCartItemPriceData($rootValue, array $args, GraphQLContext $context)
    {
        $cartItem = $this->cartItemRepository->find($rootValue->id);
        $cart = $cartItem->cart;

        return  [
            'price' => core()->formatPrice($cartItem->price, $cart->cart_currency_code),
            'base_price' => core()->formatBasePrice($cartItem->base_price),
            'custom_price' => core()->formatPrice($cartItem->custom_price, $cart->cart_currency_code),
            'total' => core()->formatPrice($cartItem->total, $cart->cart_currency_code),
            'base_total' => core()->formatBasePrice($cartItem->base_total),
            'tax_amount' => core()->formatPrice($cartItem->tax_amount, $cart->cart_currency_code),
            'base_tax_amount' => core()->formatBasePrice($cartItem->base_tax_amount),
            'discount_amount' => core()->formatPrice($cartItem->discount_amount, $cart->cart_currency_code),
            'base_discount_amount' => core()->formatBasePrice($cartItem->base_discount_amount),
        ];
    }

    /**
     * Get formatted price for Cart Shipping Rate data.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return mixed
     */
    public function getCartShippingRatePriceData($rootValue, array $args, GraphQLContext $context)
    {
        $shippingRate = $rootValue;
        $cart = $shippingRate->shipping_address->cart;

        return  [
            'price' => core()->formatPrice($shippingRate->price, $cart->cart_currency_code),
            'base_price' => core()->formatBasePrice($shippingRate->base_price)
        ];
    }
}
