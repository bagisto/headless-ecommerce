<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Setting;

use Illuminate\Database\Eloquent\Builder;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterUser extends BaseFilter
{
    /**
     * Filter the query by the given input.
     */
    public function __invoke(Builder $query, array $input): Builder
    {
        if (isset($input['role'])) {
            $query = $query->whereHas('role', function ($q) use ($input) {
                $q->where('name', $input['role']);
            });

            unset($input['role']);
        }

        return $query->where($input);
    }
}
