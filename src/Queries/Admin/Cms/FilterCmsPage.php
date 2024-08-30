<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Cms;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCmsPage extends BaseFilter
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
        if (isset($input['page_title'])) {
            $query = $query->whereHas('page_title', function ($q) use ($input) {
                $q->where('page_title', $input['page_title']);
            });

            unset($input['page_title']);
        }

        if (isset($input['url_key'])) {
            $query = $query->whereHas('url_key', function ($q) use ($input) {
                $q->where('url_key', $input['url_key']);
            });

            unset($input['url_key']);
        }

        return $query->where($input);
    }
}
