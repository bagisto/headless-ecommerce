<?php

namespace Webkul\GraphQLAPI\Queries\Sales;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterOrderInvoice extends BaseFilter
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
        if ( isset($arguments['invoice_date'])) {

            $arguments['created_at'] = $arguments['invoice_date'];

            unset($arguments['invoice_date']);
        }

        // Convert the amount parameter to base_grand_total parameter
        if ( isset($arguments['amount'])) {

            $arguments['base_grand_total'] = $arguments['amount'];

            unset($arguments['amount']);
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