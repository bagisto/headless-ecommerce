<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Sales\Orders;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterOrder extends BaseFilter
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
        if (isset($input['order_date'])) {
            $input['created_at'] = $input['order_date'];
            unset($input['order_date']);
        }

        if (
            isset($input['billed_to'])
            && isset($input['shipped_to'])
        ) {
            $billedTo = $input['billed_to'];
            $shippedTo = $input['shipped_to'];

            $billingName = $this->nameSplitter($billedTo);
            $shippedName = $this->nameSplitter($shippedTo);

            unset($input['billed_to']);
            unset($input['shipped_to']);

            return $query->where(function ($qry) use ($billingName, $shippedName) {
                $qry->whereHas('addresses', function ($q) use ($billingName) {
                    $q->where([
                        'first_name' => $billingName['firstname'],
                        'last_name'  => $billingName['lastname'],
                    ]);
                });

                $qry->whereHas('addresses', function ($q) use ($shippedName) {
                    $q->where([
                        'first_name' => $shippedName['firstname'],
                        'last_name'  => $shippedName['lastname'],
                    ]);
                });
            })->where($input);
        }

        if (isset($input['billed_to'])) {
            $billedTo = $input['billed_to'];
            $billingName = $this->nameSplitter($billedTo);

            unset($input['billed_to']);

            return $query->whereHas('addresses', function ($q) use ($billingName) {
                $q->where([
                    'first_name' => $billingName['firstname'],
                    'last_name'  => $billingName['lastname'],
                ]);
            })->where($input);
        }

        if (isset($input['shipped_to'])) {
            $shippedTo = $input['shipped_to'];
            $shippedName = $this->nameSplitter($shippedTo);

            unset($input['shipped_to']);

            return $query->whereHas('addresses', function ($q) use ($shippedName) {
                $q->where([
                    'first_name' => $shippedName['firstname'],
                    'last_name'  => $shippedName['lastname'],
                ]);
            })->where($input);
        }

        return $query->where($input);
    }
}
