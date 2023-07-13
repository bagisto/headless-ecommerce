<?php

namespace Webkul\GraphQLAPI\Type;

use Illuminate\Support\Facades\DB;
use Webkul\Product\Models\ProductFlat;
use Webkul\Product\Type\Configurable as BaseConfigurable;

class Configurable extends BaseConfigurable
{
    /**
     * Get product minimal price.
     *
     * @param  int  $qty
     * @return float
     */
    public function getMinimalPrice($qty = null)
    {
        /* method is calling many time so using variable */
        $tablePrefix = DB::getTablePrefix();

        $result = ProductFlat::join('products', 'product_flat.product_id', '=', 'products.id')
            ->distinct()
            ->where('products.parent_id', $this->product->id)
            ->selectRaw("IF( {$tablePrefix}product_flat.special_price_from IS NOT NULL
            AND {$tablePrefix}product_flat.special_price_to IS NOT NULL , IF( NOW( ) >= {$tablePrefix}product_flat.special_price_from
            AND NOW( ) <= {$tablePrefix}product_flat.special_price_to, IF( {$tablePrefix}product_flat.special_price IS NULL OR {$tablePrefix}product_flat.special_price = 0 , {$tablePrefix}product_flat.price, LEAST( {$tablePrefix}product_flat.special_price, {$tablePrefix}product_flat.price ) ) , {$tablePrefix}product_flat.price ) , IF( {$tablePrefix}product_flat.special_price_from IS NULL , IF( {$tablePrefix}product_flat.special_price_to IS NULL , IF( {$tablePrefix}product_flat.special_price IS NULL OR {$tablePrefix}product_flat.special_price = 0 , {$tablePrefix}product_flat.price, LEAST( {$tablePrefix}product_flat.special_price, {$tablePrefix}product_flat.price ) ) , IF( NOW( ) <= {$tablePrefix}product_flat.special_price_to, IF( {$tablePrefix}product_flat.special_price IS NULL OR {$tablePrefix}product_flat.special_price = 0 , {$tablePrefix}product_flat.price, LEAST( {$tablePrefix}product_flat.special_price, {$tablePrefix}product_flat.price ) ) , {$tablePrefix}product_flat.price ) ) , IF( {$tablePrefix}product_flat.special_price_to IS NULL , IF( NOW( ) >= {$tablePrefix}product_flat.special_price_from, IF( {$tablePrefix}product_flat.special_price IS NULL OR {$tablePrefix}product_flat.special_price = 0 , {$tablePrefix}product_flat.price, LEAST( {$tablePrefix}product_flat.special_price, {$tablePrefix}product_flat.price ) ) , {$tablePrefix}product_flat.price ) , {$tablePrefix}product_flat.price ) ) ) AS min_price")
            ->where('product_flat.channel', core()->getCurrentChannelCode())
            ->get();


        $minPrices = [];

        foreach ($result as $price) {
            $minPrices[] = $price->min_price;
        }

        if (empty($minPrices)) {
            return 0;
        }

        return min($minPrices);
    }

    /**
     * Get product offer price.
     *
     * @return float
     */
    public function getOfferPrice()
    {
        $rulePrices = $customerGroupPrices = [];

        foreach ($this->product->variants as $variant) {
            $rulePrice = app('Webkul\CatalogRule\Helpers\CatalogRuleProductPrice')->getRulePrice($variant);

            if ($rulePrice) {
                $rulePrices[] = $rulePrice->price;
            }

            $customerGroupPrices[] = $this->getCustomerGroupPrice($variant, 1);
        }

        if (
            $rulePrices
            || $customerGroupPrices
        ) {
            return min(array_merge($rulePrices, $customerGroupPrices));
        }

        return [];
    }

    /**
     * Get product maximum price.
     *
     * @return float
     */
    public function getMaximumPrice()
    {
        $productFlat = ProductFlat::join('products', 'product_flat.product_id', '=', 'products.id')
            ->distinct()
            ->where('products.parent_id', $this->product->id)
            ->selectRaw('MAX(' . DB::getTablePrefix() . 'product_flat.price) AS max_price')
            ->where('product_flat.channel', core()->getCurrentChannelCode())
            ->where('product_flat.locale', app()->getLocale())
            ->first();

        return $productFlat ? $productFlat->max_price : 0;
    }
}