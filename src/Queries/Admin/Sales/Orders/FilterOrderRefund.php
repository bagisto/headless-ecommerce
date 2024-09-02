<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Sales\Orders;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterOrderRefund extends BaseFilter
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
        if (isset($input['refund_date'])) {
            $input['created_at'] = $input['refund_date'];

            unset($input['refund_date']);
        }

        if (isset($input['refunded'])) {
            $input['base_grand_total'] = $input['refunded'];

            unset($input['refunded']);
        }

        if (isset($input['status'])) {
            $input['state'] = $input['status'];

            unset($input['status']);
        }

        if (isset($input['customer_name'])) {
            $nameChanger = $this->nameSplitter($input['customer_name']);

            $firstname = $nameChanger['firstname'];
            $lastname = $nameChanger['lastname'];

            unset($input['customer_name']);

            return $query->whereHas('order', function ($q) use ($firstname, $lastname) {
                $q->where([
                    'customer_first_name' => $firstname,
                    'customer_last_name'  => $lastname,
                ]);
            })->where($input);
        }

        return $query->where($input);
    }
}
