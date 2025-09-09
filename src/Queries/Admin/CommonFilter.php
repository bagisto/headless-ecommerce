<?php

namespace Webkul\GraphQLAPI\Queries\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class CommonFilter extends BaseFilter
{
    /**
     * Filter the query based on the input.
     */
    public function __invoke(Builder $query, array $input): Builder
    {
        $params = Arr::except($input, ['created_at', 'updated_at']);

        $query->when(! empty($input['created_at']), fn ($query) => $query->whereDate('created_at', $input['created_at']));

        $query->when(! empty($input['updated_at']), fn ($query) => $query->whereDate('updated_at', $input['updated_at']));

        return $query->where($params);
    }
}
