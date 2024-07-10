<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Cms;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCmsPageTranslation extends BaseFilter
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
        return $query->where($input);
    }
}
