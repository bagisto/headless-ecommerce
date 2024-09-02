<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Sales\Invoices;

use Illuminate\Database\Eloquent\Builder;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterInvoice extends BaseFilter
{
    /**
     * Filter the query by the given input.
     */
    public function __invoke(Builder $query, array $input): Builder
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
