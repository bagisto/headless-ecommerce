<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Configuration;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterConfiguration extends BaseFilter
{
    /**
     * Filter the query by the given input.
     */
    public function __invoke(Builder $query, array $input): Builder
    {
        $query = $this->applyFilter($query, Arr::only($input, ['channel_code', 'locale_code']));

        return $this->applyLikeFilter($query, Arr::only($input, ['code']));
    }

    /**
     * Get single record by the given args.
     */
    public function get(mixed $rootvalue, array $args): ?string
    {
        return core()->getConfigData($args['code']);
    }
}
