<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Customer;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class GdprQuary extends BaseFilter
{
    /**
     * Filter GDPR data requests for the authenticated customer.
     */
    public function __invoke(Builder $query, array $input): Builder
    {
        $customer = bagisto_graphql()->authorize();

        $query->where('customer_id', $customer->id);

        $exactFilters = Arr::only($input, ['id', 'status', 'type', 'revoked_at']);

        $likeFilters  = Arr::only($input, ['email', 'message']);

        $query = $this->applyLikeFilter($query, $likeFilters);

        return $query->where($exactFilters);
    }

    /**
     * Fetch a single GDPR request, ensuring it belongs to the customer.
     */
    public function getGdprRequest(Builder $query): Builder
    {
        $customer = bagisto_graphql()->authorize();

        return $query->where('customer_id', $customer->id);
    }
}
