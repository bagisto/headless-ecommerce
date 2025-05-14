<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Customer;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;
use Webkul\GraphQLAPI\Queries\BaseFilter;
use Webkul\GraphQLAPI\Validators\CustomException;

class GdprQuary extends BaseFilter
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        if (core()->getConfigData('general.gdpr.settings.enabled') != '1') {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.gdpr.not-enabled'));
        }
    }

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
