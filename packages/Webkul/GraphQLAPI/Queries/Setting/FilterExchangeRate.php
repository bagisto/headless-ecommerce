<?php

namespace Webkul\GraphQLAPI\Queries\Setting;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterExchangeRate extends BaseFilter
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

        $currency = "";

        // filter the relationship Currency
        if ( isset($arguments['currency'])) {

            $currency = $input['currency'];

            unset($arguments['currency']);
        }

        return $query->whereHas('currency', function ($q) use ($currency) {
            $q->where('name', $currency);
        })->where($arguments);
    }
}
