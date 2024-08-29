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
        $arguments = $this->getFilterParams($input);

        // Convert the order_date parameter to created_at parameter
        if (isset($arguments['order_date'])) {
            $arguments['created_at'] = $arguments['order_date'];
            unset($arguments['order_date']);
        }

        //filter Both the relationship Address for billed_to and shipped_to
        if (
            isset($arguments['billed_to'])
            && isset($arguments['shipped_to'])
        ) {
            $billedTo = $input['billed_to'];
            $shippedTo = $input['shipped_to'];

            $billingName = $this->nameSplitter($billedTo);
            $shippedName = $this->nameSplitter($shippedTo);

            unset($arguments['billed_to']);
            unset($arguments['shipped_to']);

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
            })->where($arguments);
        }

        // filter the relationship addresses for Billing Address
        if (isset($arguments['billed_to'])) {
            $billedTo = $input['billed_to'];
            $billingName = $this->nameSplitter($billedTo);

            unset($arguments['billed_to']);

            return $query->whereHas('addresses', function ($q) use ($billingName) {
                $q->where([
                    'first_name' => $billingName['firstname'],
                    'last_name'  => $billingName['lastname'],
                ]);
            })->where($arguments);
        }

        // filter the relationship addresses for Shipping Address
        if (isset($arguments['shipped_to'])) {
            $shippedTo = $input['shipped_to'];
            $shippedName = $this->nameSplitter($shippedTo);

            unset($arguments['shipped_to']);

            return $query->whereHas('addresses', function ($q) use ($shippedName) {
                $q->where([
                    'first_name' => $shippedName['firstname'],
                    'last_name'  => $shippedName['lastname'],
                ]);
            })->where($arguments);
        }

        return $query->where($arguments);
    }
}
