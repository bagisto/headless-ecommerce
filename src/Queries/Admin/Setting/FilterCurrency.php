<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Setting;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCurrency extends BaseFilter
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
        return $query->where($input);
    }
}
