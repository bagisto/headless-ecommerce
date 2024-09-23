<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Cms;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCmsPage extends BaseFilter
{
    /**
     * Filter the query by the given input.
     */
    public function __invoke(Builder $query, array $input): Builder
    {
        $params = Arr::except($input, ['page_title', 'url_key']);

        $query->whereHas('translations', function ($q) use ($input) {
            if (isset($input['page_title'])) {
                $q->where('page_title', $input['page_title']);
            }

            if (isset($input['url_key'])) {
                $q->where('url_key', $input['url_key']);
            }
        });

        return $query->where($params);
    }
}
