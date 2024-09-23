<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Customer;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class RefundQuery
{
    /**
     * Filter query for order refunds.
     */
    public function __invoke(mixed $query, array $input): Builder
    {
        $customer = bagisto_graphql()->authorize();

        $params = Arr::except($input, ['refund_date']);

        $query->when(Arr::has($input, 'refund_date'), function ($query) use ($input) {
            $query->whereDate('created_at', $input['refund_date']);
        });

        $query->whereHas('order', function ($query) use ($customer) {
            $query->where('customer_id', $customer->id);
        });

        return $query->where($params)->orderBy('id', 'desc');
    }

    /**
     * Get the specified refund details.
     */
    public function getRefund(Builder $query): Builder
    {
        $customer = bagisto_graphql()->authorize();

        return $query->whereHas('order', function ($query) use ($customer) {
            $query->where('customer_id', $customer->id);
        });
    }
}
