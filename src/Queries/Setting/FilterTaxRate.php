<?php

namespace Webkul\GraphQLAPI\Queries\Setting;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterTaxRate extends BaseFilter
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

        // check the value for the input state *
        if ( isset($arguments['state']) && $input['state']  == "*") {

            unset($arguments['state']);

            return $query->where(function ($q) {
                $q->where('state', "");
            })->where($arguments);
        }

        return $query->where($arguments);
    }
}
