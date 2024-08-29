<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Customer;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterReview extends BaseFilter
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
