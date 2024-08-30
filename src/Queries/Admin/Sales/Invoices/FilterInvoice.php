<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Sales\Invoices;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterInvoice extends BaseFilter
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
        if (isset($input['invoice_date'])) {
            $input['created_at'] = $input['invoice_date'];

            unset($input['invoice_date']);
        }

        if (isset($input['grand_total'])) {
            $input['base_grand_total'] = $input['grand_total'];

            unset($input['grand_total']);
        }

        return $query->where($input);
    }
}
