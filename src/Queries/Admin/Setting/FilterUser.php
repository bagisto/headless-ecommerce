<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Setting;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterUser extends BaseFilter
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
        if (isset($input['role'])) {
            $query = $query->whereHas('role', function ($q) use ($input) {
                $q->where('name', $input['role']);
            });

            unset($input['role']);
        }

        return $query->where($input);
    }
}
