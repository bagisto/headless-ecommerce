<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Catalog\Categories;

use Illuminate\Database\Eloquent\Builder;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCategory extends BaseFilter
{
    /**
     * filter the category's query
     */
    public function __invoke(Builder $query, array $input): Builder
    {
        $qbConditions = [];

        foreach ($input as $key => $argument) {
            if (! $argument) {
                unset($input[$key]);
            }

            if (
                in_array($key, ['name', 'slug'])
                && $argument
            ) {
                $qbConditions[$key] = $argument;

                unset($input[$key]);
            }
        }

        return $query->whereHas('translation', function ($q) use ($qbConditions) {
            foreach ($qbConditions as $column => $condition) {
                $q->where($column, 'like', '%'.urldecode($condition).'%');
            }
        })->where($input);
    }
}
