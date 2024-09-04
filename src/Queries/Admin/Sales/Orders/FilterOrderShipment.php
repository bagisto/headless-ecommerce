<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Sales\Orders;

use Illuminate\Database\Eloquent\Builder;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterOrderShipment extends BaseFilter
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

        if (isset($input['tracking_number'])) {
            $input['track_number'] = $input['tracking_number'];

            unset($input['tracking_number']);
        }

        return $query->where($input);
    }
}
