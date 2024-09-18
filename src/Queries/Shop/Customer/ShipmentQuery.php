<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Customer;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class ShipmentQuery
{
    /**
     * Filter query for order shipments.
     */
    public function __invoke(mixed $query, array $input): Builder
    {
        $customer = bagisto_graphql()->authorize();

        $params = Arr::except($input, ['shipment_date', 'carrier_title']);

        $query->when(Arr::has($input, 'shipment_date'), function ($query) use ($input) {
            $query->whereDate('created_at', $input['shipment_date']);
        });

        $query->when(Arr::has($input, 'carrier_title'), function ($query) use ($input) {
            $query->where('carrier_title', 'like', '%'.$input['carrier_title'].'%');
        });

        $query->whereHas('order', function ($query) use ($customer) {
            $query->where('customer_id', $customer->id);
        });

        return $query->where($params)->orderBy('id', 'desc');
    }

    /**
     * Get the specified order shipment.
     */
    public function getShipment(Builder $query): Builder
    {
        $customer = bagisto_graphql()->authorize();

        return $query->whereHas('order', function ($query) use ($customer) {
            $query->where('customer_id', $customer->id);
        });
    }
}
