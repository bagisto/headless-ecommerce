<?php

namespace Webkul\GraphQLAPI\Queries\Sales;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterRefund extends BaseFilter
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

        // Convert the refund_date parameter to created_at parameter
         if ( isset($arguments['refund_date'])) {

            $arguments['created_at'] = $arguments['refund_date'];

            unset($arguments['refund_date']);
        }

        // Convert the refunded parameter to base_grand_total parameter
        if ( isset($arguments['refunded'])) {

            $arguments['base_grand_total'] = $arguments['refunded'];

            unset($arguments['refunded']);
        }

        // filter the relationship order addresses for Billing Address
        if ( isset($arguments['billed_to'])) {

            $billed_to = $input['billed_to'];

            $billingName =$this->nameSplitter($billed_to);

            unset($arguments['billed_to']);

            return $query->whereHas('order.addresses',function ($q) use ($billingName) {
                $q->where(['first_name' => $billingName['firstname'],
                    'last_name' => $billingName['lastname']]);
            })->where($arguments);
        }
        
        return $query->where($arguments);
    }
}