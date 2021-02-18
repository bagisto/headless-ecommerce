<?php

namespace Webkul\GraphQLAPI\Queries\Sales;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterOrderRefund extends BaseFilter
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

        // Convert the Status parameter to State parameter
        if ( isset($arguments['status'])) {

            $arguments['state'] = $arguments['status'];

            unset($arguments['status']);
        }

        // ilter the relationship Customer Name
        if ( isset($arguments['customer_name'])) {

            $nameChanger = $this->nameSplitter($arguments['customer_name']);

            $firstname = $nameChanger['firstname'];

            $lastname = $nameChanger['lastname'];

            unset($arguments['customer_name']);

            return $query->whereHas('order',function ($q) use ($firstname,$lastname) {
                $q->where(['customer_first_name' => $firstname,
                    'customer_last_name' => $lastname]);
            })->where($arguments);
        }
        
        return $query->where($arguments);
    }
}