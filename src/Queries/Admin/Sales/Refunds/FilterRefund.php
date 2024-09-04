<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Sales\Refunds;

use Illuminate\Database\Eloquent\Builder;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterRefund extends BaseFilter
{
    /**
     * Filter the query by the given input.
     */
    public function __invoke(Builder $query, array $input): Builder
    {
        if (isset($input['refund_date'])) {
            $input['created_at'] = $input['refund_date'];
            unset($input['refund_date']);
        }

        if (isset($input['refunded'])) {
            $input['base_grand_total'] = $input['refunded'];
            unset($input['refunded']);
        }

        if (isset($input['billed_to'])) {
            $billedTo = $input['billed_to'];
            $billingName = $this->nameSplitter($billedTo);

            unset($input['billed_to']);

            return $query->whereHas('order.addresses', function ($q) use ($billingName) {
                $q->where(['first_name' => $billingName['firstname'],
                    'last_name'         => $billingName['lastname']]);
            })->where($input);
        }

        return $query->where($input);
    }
}
