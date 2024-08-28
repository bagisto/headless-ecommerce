<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Marketing\SEO;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterSitemap extends BaseFilter
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
