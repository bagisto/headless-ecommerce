<?php

namespace Webkul\GraphQLAPI\Queries\Velocity;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterOrderBrand extends BaseFilter
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

         // filter the relationship Brand Name
        if ( isset($arguments['brand_name']) && isset($arguments['category_name'])) {

            $brand_name = $input['brand_name'];

            $category_name = $input['category_name'];
            
            unset($arguments['brand_name']);
            
            unset($arguments['category_name']);


            return $query->where(function($qry) use($brand_name,$category_name){
                $qry->whereHas('getBrands',function ($q) use ($brand_name) {
                    $q->where("admin_name", $brand_name);
                });

                $qry->whereHas('categories.translations',function ($q) use ($category_name) {
                    $q->where("name", $category_name);
                });
            })->where($arguments);
        }


       // filter the relationship Brand Name
       if ( isset($arguments['brand_name'])) {

            $brand_name = $input['brand_name'];
            
            unset($arguments['brand_name']);

            return $query->whereHas('getBrands',function ($q) use ($brand_name) {
                $q->where("admin_name", $brand_name);
            })->where($arguments);
        }

        // filter the relationship Categories
        if ( isset($arguments['category_name'])) {

            $category_name = $input['category_name'];
            
            unset($arguments['category_name']);

            return $query->whereHas('categories.translations',function ($q) use ($category_name) {
                $q->where("name", $category_name);
            })->where($arguments);
        }

        return $query->where($arguments);       
    } 
}  
