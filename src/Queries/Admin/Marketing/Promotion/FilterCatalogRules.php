<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Marketing\Promotion;

use Illuminate\Database\Eloquent\Builder;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCatalogRules extends BaseFilter
{
    /**
     * Filter the query by the given input.
     */
    public function __invoke(Builder $query, array $input): Builder
    {
        if (isset($input['start'])) {
            $input['starts_from'] = $input['start'];

            unset($input['start']);
        }

        if (isset($input['end'])) {
            $input['ends_till'] = $input['end'];

            unset($input['end']);
        }

        if (isset($input['priority'])) {
            $input['sort_order'] = $input['priority'];

            unset($input['priority']);
        }

        return $query->where($input);
    }
}
