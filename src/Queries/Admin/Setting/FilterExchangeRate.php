<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Setting;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterExchangeRate extends BaseFilter
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
        if (isset($input['currency'])) {
            $query = $query->whereHas('currency', function ($q) use ($input) {
                $q->where('name', $input['currency']);
            });

            unset($input['currency']);
        }

        return $query->where($input);
    }
}
