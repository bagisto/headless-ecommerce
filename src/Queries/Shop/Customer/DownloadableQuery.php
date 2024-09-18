<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Customer;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class DownloadableQuery extends BaseFilter
{
    /**
     * Filter query for the downloadable product.
     */
    public function __invoke(Builder $query, array $input): Builder
    {
        $customer = bagisto_graphql()->authorize();

        $query->where('customer_id', $customer->id);

        $params = Arr::except($input, ['product_name', 'name']);

        $query = $this->applyLikeFilter($query, Arr::only($input, ['product_name', 'name']));

        return $query->where($params);
    }

    /**
     * Get the specified review details.
     */
    public function getDetails(Builder $query): Builder
    {
        $customer = bagisto_graphql()->authorize();

        return $query->where('customer_id', $customer->id);
    }
}
