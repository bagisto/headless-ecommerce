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

        $params = Arr::except($input, [
            'product_name',
            'name',
            'purchase_date',
            'purchase_date_from',
            'purchase_date_to',
        ]);

        if (! empty($input['purchase_date'])) {
            $query->whereDate('created_at', $input['purchase_date']);
        } elseif (
            ! empty($input['purchase_date_from'])
            && ! empty($input['purchase_date_to'])
        ) {
            $query->whereDate('created_at', '>=', $input['purchase_date_from'])
                ->whereDate('created_at', '<=', $input['purchase_date_to']);
        }

        $query = $this->applyLikeFilter($query, Arr::only($input, ['product_name', 'name']));

        return $query->where($params)->orderBy('created_at', 'desc');
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
