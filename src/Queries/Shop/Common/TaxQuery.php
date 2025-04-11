<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Webkul\GraphQLAPI\Queries\BaseFilter;
use Webkul\Tax\Facades\Tax;

class TaxQuery extends BaseFilter
{
    /**
     * Get the tax rates and tax amount for the cart.
     *
     * @var array
     */
    public function appliedTaxRates($cart)
    {
        $taxes = collect(Tax::getTaxRatesWithAmount($cart, true))->map(function ($rate, $name) {
            return [
                'tax_name'     => $name,
                'total_amount' => core()->currency($rate ?? 0),
            ];
        })->values()->toArray();

        return $taxes;
    }
}
