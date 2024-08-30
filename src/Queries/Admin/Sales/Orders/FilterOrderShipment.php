<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Sales\Orders;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterOrderShipment extends BaseFilter
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
        if (isset($input['shipment_date'])) {
            $input['created_at'] = $input['shipment_date'];

            unset($input['shipment_date']);
        }

        if (isset($input['tracking_number'])) {
            $input['track_number'] = $input['tracking_number'];

            unset($input['tracking_number']);
        }

        return $query->where($input);
    }
}
