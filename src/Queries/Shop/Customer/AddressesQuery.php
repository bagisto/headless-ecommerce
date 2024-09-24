<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Customer;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class AddressesQuery extends BaseFilter
{
    /**
     * Filter query for the customer addresses.
     */
    public function __invoke(Builder $query, array $input): Builder
    {
        $customer = bagisto_graphql()->authorize();

        $params = Arr::except($input, ['first_name', 'last_name', 'company_name', 'address', 'city']);

        $likeParams = Arr::only($input, ['first_name', 'last_name', 'company_name', 'address', 'city']);

        $params['customer_id'] = $customer->id;

        $query = $this->applyLikeFilter($query, $likeParams);

        return $query->where($params);
    }

    /**
     * Get the specified address.
     */
    public function getAddress(Builder $query): Builder
    {
        $customer = bagisto_graphql()->authorize();

        return $query->where('customer_id', $customer->id);
    }
}
