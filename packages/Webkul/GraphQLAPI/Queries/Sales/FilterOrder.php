<?php

namespace Webkul\GraphQLAPI\Queries\Sales;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterOrder extends BaseFilter
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

        // Convert the order_date parameter to created_at parameter
        if ( isset($arguments['order_date'])) {

            $arguments['created_at'] = $arguments['order_date'];

            unset($arguments['order_date']);
        }

       //filter Both the relationship Address for billed_to and shipped_to
       if ( isset($arguments['billed_to']) && isset($arguments['shipped_to']) ) {

            $billed_to = $input['billed_to'];

            $shipped_to = $input['shipped_to'];

            $billingName =$this->nameSplitter($billed_to);

            $shippedName =$this->nameSplitter($shipped_to);

            unset($arguments['billed_to']);

            unset($arguments['shipped_to']);

            return $query->where(function($qry) use($billingName,$shippedName){
                $qry->whereHas('addresses',function ($q) use ($billingName) {
                    $q->where(['first_name' => $billingName['firstname'],
                    'last_name' => $billingName['lastname']]);
                });

                $qry->whereHas('addresses',function ($q) use ($shippedName) {
                    $q->where(['first_name' => $shippedName['firstname'],
                    'last_name' => $shippedName['lastname']]);
                });
            })->where($arguments);
        }      

        // filter the relationship addresses for Billing Address
        if ( isset($arguments['billed_to'])) {

            $billed_to = $input['billed_to'];

            $billingName =$this->nameSplitter($billed_to);

            unset($arguments['billed_to']);

            return $query->whereHas('addresses',function ($q) use ($billingName) {
                $q->where(['first_name' => $billingName['firstname'],
                    'last_name' => $billingName['lastname']]);
            })->where($arguments);
        }

        // filter the relationship addresses for Shipping Address
        if ( isset($arguments['shipped_to'])) {

            $shipped_to = $input['shipped_to'];

            $shippedName =$this->nameSplitter($shipped_to);

            unset($arguments['shipped_to']);

            return $query->whereHas('addresses',function ($q) use ($shippedName) {
                $q->where(['first_name' => $shippedName['firstname'],
                    'last_name' => $shippedName['lastname']]);
            })->where($arguments);
        }

        return $query->where($arguments);
    }   
}