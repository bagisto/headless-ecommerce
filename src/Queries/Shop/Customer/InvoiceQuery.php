<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Customer;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class InvoiceQuery
{
    /**
     * Filter query for order invoices.
     */
    public function __invoke(mixed $query, array $input): Builder
    {
        $customer = bagisto_graphql()->authorize();

        $params = Arr::except($input, ['invoice_date']);

        $query->when(Arr::has($input, 'invoice_date'), function ($query) use ($input) {
            $query->whereDate('created_at', $input['invoice_date']);
        });

        $query->whereHas('order', function ($query) use ($customer) {
            $query->where('customer_id', $customer->id);
        });

        return $query->where($params)->orderBy('id', 'desc');
    }

    /**
     * Get the specified order invoice.
     */
    public function getInvoice(Builder $query): Builder
    {
        $customer = bagisto_graphql()->authorize();

        return $query->whereHas('order', function ($query) use ($customer) {
            $query->where('customer_id', $customer->id);
        });
    }
}
