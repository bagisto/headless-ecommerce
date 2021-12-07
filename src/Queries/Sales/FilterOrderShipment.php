<?php

namespace Webkul\GraphQLAPI\Queries\Sales;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterOrderShipment extends BaseFilter
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
         if ( isset($arguments['shipment_date'])) {

            $arguments['created_at'] = $arguments['shipment_date'];

            unset($arguments['shipment_date']);
        }

        // Convert the inventory_source parameter to inventory_source_name parameter
        if ( isset($arguments['tracking_number'])) {

            $arguments['track_number'] = $arguments['tracking_number'];

            unset($arguments['tracking_number']);
        }
        
        return $query->where($arguments);
    }
}