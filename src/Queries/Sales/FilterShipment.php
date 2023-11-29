<?php

namespace Webkul\GraphQLAPI\Queries\Sales;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterShipment extends BaseFilter
{
    /**
     * filter the data .
     *
     * @param  object  $query
     * @param  array $input
     * @return \Illuminate\Http\Response
     */
    public function __invoke($query, $input)
    {
        $arguments = $this->getFilterParams($input);    

        // Convert the shipment_date parameter to created_at parameter
         if (isset($arguments['shipment_date'])) {
            $arguments['created_at'] = $arguments['shipment_date'];
            unset($arguments['shipment_date']);
        }

        // Convert the inventory_source parameter to inventory_source_name parameter
        if (isset($arguments['inventory_source'])) {
            $arguments['inventory_source_name'] = $arguments['inventory_source'];
            unset($arguments['inventory_source']);
        }

        // ilter the relationship Order and Address
        if (isset($arguments['order_date']) && isset($arguments['shipping_to'])) {
            $orderDate = $arguments['order_date'];
            $shippedTo = $input['shipping_to'];
            $shippedName = $this->nameSplitter($shippedTo);

            unset($arguments['shipping_to']);
            unset($arguments['order_date']);

            return $query->whereHas('order',function ($q) use ($orderDate,$shippedName) {
                $q->where('created_at', $orderDate);

                $q->whereHas('addresses',function ($qry) use ($shippedName) {
                    $qry->where(['first_name' => $shippedName['firstname'],
                        'last_name' => $shippedName['lastname']]);
                });
            })->where($arguments);
        }

        // filter the relationship Order
        if (isset($arguments['order_date'])) {
            $orderDate = $arguments['order_date'];

            unset($arguments['order_date']);

            return $query->whereHas('order',function ($q) use ($orderDate) {
                $q->where('created_at', $orderDate);
            })->where($arguments);
        }

         // filter the relationship addresses for Shipping Address
         if (isset($arguments['shipping_to'])) {
            $shippedTo = $input['shipping_to'];
            $shippedName = $this->nameSplitter($shippedTo);

            unset($arguments['shipping_to']);

            return $query->whereHas('order.addresses',function ($q) use ($shippedName) {
                $q->where(['first_name' => $shippedName['firstname'],
                    'last_name' => $shippedName['lastname']]);
            })->where($arguments);
        }
        
        return $query->where($arguments);
    }
}