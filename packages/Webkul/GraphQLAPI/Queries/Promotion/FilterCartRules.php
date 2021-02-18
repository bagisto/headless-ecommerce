<?php

namespace Webkul\GraphQLAPI\Queries\Promotion;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCartRules extends BaseFilter
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
       
        // Convert the invoice_date parameter to created_at parameter
        if ( isset($arguments['start'])) {

            $arguments['starts_from'] = $arguments['start'];

            unset($arguments['start']);
        }

        // Convert the grand_total parameter to base_grand_total parameter
        if ( isset($arguments['end'])) {

            $arguments['ends_till'] = $arguments['end'];

            unset($arguments['end']);
        }


        // Convert the grand_total parameter to base_grand_total parameter
        if ( isset($arguments['priority'])) {

            $arguments['sort_order'] = $arguments['priority'];

            unset($arguments['priority']);
        }

         // filter the relationship Coupon Code
         if ( isset($arguments['coupon_code'])) {

            $coupon_code = $input['coupon_code'];

            unset($arguments['coupon_code']);

            return $query->whereHas('cart_rule_coupon', function ($q) use ($coupon_code) {
                $q->where(['code' => $coupon_code , 'is_primary' => 1]);
            })->where($arguments);
        }

        return $query->where($arguments);
    } 
}  
