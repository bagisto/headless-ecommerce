<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCompareProduct extends BaseFilter
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
         
         //filter Both the relationship Product Flat for name and price
       if ( isset($arguments['name']) && isset($arguments['price']) ) {

            $name = $input['name'];

            $price = $input['price'];


            unset($arguments['name']);

            unset($arguments['price']);

            return $query->whereHas('product_flat',function ($q) use ($name,$price) {
                $q->where(['name' => $name,
                    'price' => $price]);
            })->where($arguments);
        }      

        // filter the relationship Product Flat for name 
        if ( isset($arguments['name'])) {

            $name = $input['name'];

            unset($arguments['name']);

            return $query->whereHas('product_flat',function ($q) use ($name) {
                $q->where("name", $name);
            })->where($arguments);
        }

        // filter the relationship Product Flat for price
        if ( isset($arguments['price'])) {

            $price = $input['price'];

            unset($arguments['price']);

            return $query->whereHas('product_flat',function ($q) use ($price) {
                $q->where("price", $price);
            })->where($arguments);
        }

        return $query->where($arguments);
    }
}