<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Marketing\Communications;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCampaign extends BaseFilter
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
        $arguments = $this->getFilterParams($input);

        return $query->where($arguments);
    }
}
