<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FormattedPrice extends BaseFilter
{
    /**
     * Get formatted price for Cart.
     */
    public function getCartPriceData(object $cart): array
    {
        return $this->getFormattedPrice($cart, $cart->cart_currency_code);
    }

    /**
     * Get formatted price for Cart Item.
     */
    public function getCartItemPriceData(object $cartItem): array
    {
        return $this->getFormattedPrice($cartItem, $cartItem->cart->cart_currency_code);
    }

    /**
     * Get formatted price for Cart Shipping Rate.
     */
    public function getCartShippingRatePriceData(object $shippingRate): array
    {
        return $this->getFormattedPrice($shippingRate, $shippingRate->shipping_address->cart->cart_currency_code);
    }
}
