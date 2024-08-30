<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Setting;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterTaxRate extends BaseFilter
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
        if (
            isset($arguments['state'])
            && $input['state'] == '*'
        ) {
            $query = $query->where(function ($q) {
                $q->where('state', '');
            });

            unset($input['state']);
        }

        return $query->where($input);
    }
}
