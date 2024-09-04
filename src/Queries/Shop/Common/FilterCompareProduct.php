<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Illuminate\Database\Eloquent\Builder;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCompareProduct extends BaseFilter
{
    /**
     * Filter the query by the given input.
     */
    public function __invoke(Builder $query, array $input): Builder
    {
        if (
            isset($input['name'])
            && isset($input['price'])
        ) {
            $name = $input['name'];
            $price = $input['price'];

            unset($input['name']);
            unset($input['price']);

            return $query->whereHas('product_flat', function ($q) use ($name, $price) {
                $q->where([
                    'name'  => $name,
                    'price' => $price,
                ]);
            })->where($input);
        }

        if (isset($input['name'])) {
            $name = $input['name'];
            unset($input['name']);

            return $query->whereHas('product_flat', function ($q) use ($name) {
                $q->where('name', $name);
            })->where($input);
        }

        if (isset($input['price'])) {
            $price = $input['price'];
            unset($input['price']);

            return $query->whereHas('product_flat', function ($q) use ($price) {
                $q->where('price', $price);
            })->where($input);
        }

        return $query->where($input);
    }
}
