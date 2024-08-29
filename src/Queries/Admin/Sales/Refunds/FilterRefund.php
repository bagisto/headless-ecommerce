<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Sales\Refunds;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterRefund extends BaseFilter
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
        $arguments = $this->getFilterParams($input);

        // Convert the refund_date parameter to created_at parameter
        if (isset($arguments['refund_date'])) {
            $arguments['created_at'] = $arguments['refund_date'];
            unset($arguments['refund_date']);
        }

        // Convert the refunded parameter to base_grand_total parameter
        if (isset($arguments['refunded'])) {
            $arguments['base_grand_total'] = $arguments['refunded'];
            unset($arguments['refunded']);
        }

        // filter the relationship order addresses for Billing Address
        if (isset($arguments['billed_to'])) {
            $billedTo = $input['billed_to'];
            $billingName = $this->nameSplitter($billedTo);

            unset($arguments['billed_to']);

            return $query->whereHas('order.addresses', function ($q) use ($billingName) {
                $q->where(['first_name' => $billingName['firstname'],
                    'last_name'         => $billingName['lastname']]);
            })->where($arguments);
        }

        return $query->where($arguments);
    }
}
