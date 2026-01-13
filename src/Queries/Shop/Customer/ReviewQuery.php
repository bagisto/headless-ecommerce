<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Customer;

use Illuminate\Database\Eloquent\Builder;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class ReviewQuery extends BaseFilter
{
    /**
     * Filter query for the product review.
     */
    public function __invoke(Builder $query, array $input): Builder
    {
        if (auth()->guard('api')->check()) {
            $customer = auth()->guard('api')->user();
        }

        $query->where('product_reviews.customer_id', $customer->id);

        $filters = [
            'product_reviews.id'         => $input['id'] ?? null,
            'product_reviews.rating'     => $input['rating'] ?? null,
            'product_reviews.product_id' => $input['product_id'] ?? null,
            'product_reviews.status'     => $input['status'] ?? null,
        ];

        $query = $this->applyFilter($query, $filters);

        $likeFilters = [
            'product_reviews.name'  => $input['customer_name'] ?? null,
            'product_reviews.title' => $input['title'] ?? null,
        ];

        $query = $this->applyLikeFilter($query, $likeFilters);

        $query->when(! empty($input['product_name']), function ($query) use ($input) {
            $query->whereHas('product.product_flats', function ($q) use ($input) {
                $q->where('name', 'like', '%'.$input['product_name'].'%');
            });
        });

        return $query;
    }

    /**
     * Get the specified review details.
     */
    public function getDetails(Builder $query): Builder
    {
        if (auth()->guard('api')->check()) {
            $customer = auth()->guard('api')->user();
        }

        return $query->where('customer_id', $customer->id ?? null);
    }
}
