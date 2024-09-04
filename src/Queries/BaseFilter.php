<?php

namespace Webkul\GraphQLAPI\Queries;

use Illuminate\Database\Eloquent\Builder;

class BaseFilter
{
    /**
     * Fields that are used for price formatting
     *
     * @var array
     */
    protected $priceAttributes = [
        'adjustment_fee',
        'adjustment_refund',
        'amount_refunded',
        'base_adjustment_fee',
        'base_adjustment_refund',
        'base_amount_refunded',
        'base_discount',
        'base_discount_amount',
        'base_discount_invoiced',
        'base_discount_refunded',
        'base_discounted_sub_total',
        'base_grand_total',
        'base_grand_total_invoiced',
        'base_grand_total_refunded',
        'base_price',
        'base_price_incl_tax',
        'base_shipping_amount',
        'base_shipping_amount_incl_tax',
        'base_shipping_discount_amount',
        'base_shipping_invoiced',
        'base_shipping_refunded',
        'base_shipping_tax_amount',
        'base_shipping_tax_refunded',
        'base_sub_total',
        'base_sub_total_incl_tax',
        'base_sub_total_invoiced',
        'base_tax_amount',
        'base_tax_amount_invoiced',
        'base_tax_amount_refunded',
        'base_tax_total',
        'base_total',
        'base_total_incl_tax',
        'base_total_invoiced',
        'custom_price',
        'discount',
        'discount_amount',
        'discount_invoiced',
        'discount_refunded',
        'discounted_sub_total',
        'grand_total',
        'grand_total_invoiced',
        'grand_total_refunded',
        'price',
        'price_incl_tax',
        'shipping_amount',
        'shipping_amount_incl_tax',
        'shipping_discount_amount',
        'shipping_invoiced',
        'shipping_refunded',
        'shipping_tax_amount',
        'shipping_tax_refunded',
        'sub_total',
        'sub_total_incl_tax',
        'sub_total_invoiced',
        'sub_total_refunded',
        'tax_amount',
        'tax_amount_invoiced',
        'tax_amount_refunded',
        'tax_total',
        'total',
        'total_incl_tax',
        'total_invoiced',
    ];

    /**
     * Get the formatted price
     */
    protected function getFormattedPrice(object $model, string $currencyCode): array
    {
        $priceData = [];

        foreach ($this->priceAttributes as $attribute) {
            if (isset($model->{$attribute})) {
                $isBasePrice = strpos($attribute, 'base_') === 0;

                $priceData[$attribute] = $isBasePrice
                    ? core()->formatBasePrice($model->{$attribute})
                    : core()->formatPrice($model->{$attribute}, $currencyCode);
            }
        }

        return $priceData;
    }

    /**
     * Split the name into firstname and lastname.
     */
    protected function nameSplitter(?string $name): array
    {
        $nameParts = explode(' ', $name, 2);

        return [
            'firstname' => current($nameParts),
            'lastname'  => $nameParts[1] ?? '',
        ];
    }

    /**
     * Apply filter on the query.
     */
    protected function applyFilter(Builder $query, array $filters): Builder
    {
        foreach ($filters as $column => $value) {
            if (! empty($value)) {
                $query->where($column, $value);
            }
        }

        return $query;
    }

    /**
     * Apply filter on the query.
     */
    protected function applyLikeFilter(Builder $query, array $filters): Builder
    {
        foreach ($filters as $column => $value) {
            if (! empty($value)) {
                $query->where($column, 'like', '%'.$value.'%');
            }
        }

        return $query;
    }
}
