<?php

namespace Webkul\GraphQLAPI\Queries\Promotion;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCatalogRules extends BaseFilter
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
       
        // Convert the invoice_date parameter to created_at parameter
        if ( isset($arguments['start'])) {

            $arguments['starts_from'] = $arguments['start'];

            unset($arguments['start']);
        }

        // Convert the grand_total parameter to base_grand_total parameter
        if ( isset($arguments['end'])) {

            $arguments['ends_till'] = $arguments['end'];

            unset($arguments['end']);
        }


        // Convert the grand_total parameter to base_grand_total parameter
        if ( isset($arguments['priority'])) {

            $arguments['sort_order'] = $arguments['priority'];

            unset($arguments['priority']);
        }

        return $query->where($arguments);
    } 
}  
