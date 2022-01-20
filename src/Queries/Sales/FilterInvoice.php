<?php

namespace Webkul\GraphQLAPI\Queries\Sales;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterInvoice extends BaseFilter
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

        // Convert the grand_total parameter to base_grand_total parameter
        if ( isset($arguments['grand_total'])) {

            $arguments['base_grand_total'] = $arguments['grand_total'];

            unset($arguments['grand_total']);
        }

        return $query->where($arguments);
    }
}