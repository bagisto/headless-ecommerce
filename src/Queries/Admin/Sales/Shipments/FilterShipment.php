<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Sales\Shipments;

use Illuminate\Database\Eloquent\Builder;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterShipment extends BaseFilter
{
    /**
     * Filter the query by the given input.
     */
    public function __invoke(Builder $query, array $input): Builder
    {
        if (isset($input['shipment_date'])) {
            $input['created_at'] = $input['shipment_date'];

            unset($input['shipment_date']);
        }

        if (isset($input['inventory_source'])) {
            $input['inventory_source_name'] = $input['inventory_source'];

            unset($input['inventory_source']);
        }

        if (
            isset($input['order_date'])
            && isset($input['shipping_to'])
        ) {
            $orderDate = $input['order_date'];
            $shippedTo = $input['shipping_to'];

            $shippedName = $this->nameSplitter($shippedTo);

            unset($input['shipping_to']);
            unset($input['order_date']);

            return $query->whereHas('order', function ($q) use ($orderDate, $shippedName) {
                $q->where('created_at', $orderDate);

                $q->whereHas('addresses', function ($qry) use ($shippedName) {
                    $qry->where([
                        'first_name' => $shippedName['firstname'],
                        'last_name'  => $shippedName['lastname'],
                    ]);
                });
            })->where($input);
        }

        if (isset($input['order_date'])) {
            $orderDate = $input['order_date'];

            unset($input['order_date']);

            return $query->whereHas('order', function ($q) use ($orderDate) {
                $q->where('created_at', $orderDate);
            })->where($input);
        }

        if (isset($input['shipping_to'])) {
            $shippedTo = $input['shipping_to'];
            $shippedName = $this->nameSplitter($shippedTo);

            unset($input['shipping_to']);

            return $query->whereHas('order.addresses', function ($q) use ($shippedName) {
                $q->where([
                    'first_name' => $shippedName['firstname'],
                    'last_name'  => $shippedName['lastname'],
                ]);
            })->where($input);
        }

        return $query->where($input);
    }
}
