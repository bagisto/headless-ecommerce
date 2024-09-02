<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Catalog\Products;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterProducts extends BaseFilter
{
    /**
     * filter the data .
     *
     * @param  object  $query
     * @param  array  $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function __invoke($query, $input)
    {
        $attributeFamily = '';

        $qty = '';

        if (
            isset($input['attribute_family'])
            && isset($input['qty'])
        ) {
            $attributeFamily = $input['attribute_family'];

            $qty = $input['qty'];

            unset($input['attribute_family']);
            unset($input['qty']);

            return $query->where(function ($qry) use ($attributeFamily, $qty) {
                $qry->whereHas('attribute_family', function ($q) use ($attributeFamily) {
                    $q->where('name', $attributeFamily);
                });

                $qry->whereHas('inventories', function ($q) use ($qty) {
                    $q->where('qty', $qty);
                });
            })->where($input);
        }

        if (isset($input['attribute_family'])) {

            $attributeFamily = $input['attribute_family'];

            unset($input['attribute_family']);

            return $query->whereHas('attribute_family', function ($q) use ($attributeFamily) {
                $q->where('name', $attributeFamily);
            })->where($input);
        }

        if (
            isset($input['qty'])
            || array_key_exists('qty', $input)
        ) {
            $qty = $input['qty'];

            unset($input['qty']);

            return $query->whereHas('inventories', function ($q) use ($qty) {
                $q->where('qty', $qty);
            })->where($input);
        }

        return $query->where($input);
    }
}
