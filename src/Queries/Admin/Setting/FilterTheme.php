<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Setting;

use Illuminate\Database\Eloquent\Builder;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterTheme extends BaseFilter
{
    /**
     * Filter the query by the given input.
     */
    public function __invoke(Builder $query, array $input): Builder
    {
        if (isset($input['channel'])) {
            $query = $query->whereHas('channel', function ($q) use ($input) {
                $q->where('name', $input['channel']);
            });

            unset($input['channel']);
        }

        return $query->where($input);
    }
}
