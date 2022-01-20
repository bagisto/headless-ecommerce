<?php

namespace Webkul\GraphQLAPI\Queries\Catalog;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterProducts extends BaseFilter
{
    /**
     * filter the data .
     *
     * @param  object  $query
     * @param  array $input
     * @return \Illuminate\Http\Response
     */
    public function __invoke($query, $input)
    {
        $arguments = $this->getFilterParams($input);

        $attribute_family = "";

        $qty = "";
        
        // filter Both the relationship Attribute Family as well the Inventories
        if ( isset($arguments['attribute_family']) && isset($arguments['qty']) ) {

            $attribute_family = $input['attribute_family'];

            $qty = $input['qty'];

            unset($arguments['attribute_family']);
            unset($arguments['qty']);

            return $query->where(function($qry) use($attribute_family,$qty){
                $qry->whereHas('attribute_family',function ($q) use ($attribute_family) {
                    $q->where('name',$attribute_family);
                });

                $qry->whereHas('inventories',function ($q) use ($qty) {
                    $q->where('qty',$qty);
                });
            })->where($arguments);
        }

        // filter the relationship Attribute Family
        if ( isset($arguments['attribute_family'])) {

            $attribute_family = $input['attribute_family'];

            unset($arguments['attribute_family']);

            return $query->whereHas('attribute_family',function ($q) use ($attribute_family) {
                $q->where('name',$attribute_family);
            })->where($arguments);
        }

        // filter the relationship Inventories
        if ( isset($arguments['qty']) || array_key_exists("qty",$input)) {

            $qty = $input['qty'];

            unset($arguments['qty']);

            return $query->whereHas('inventories',function ($q) use ($qty) {
                $q->where('qty',$qty);
            })->where($arguments);
        }

        return $query->where($arguments);
    }
}
