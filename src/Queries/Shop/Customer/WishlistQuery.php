<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Customer;

use Illuminate\Database\Eloquent\Builder;
use Webkul\Customer\Repositories\WishlistRepository;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class WishlistQuery extends BaseFilter
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected WishlistRepository $wishlistRepository) {}

    /**
     * Filter query for wishlist.
     */
    public function __invoke(Builder $query, array $input): Builder
    {
        $customer = bagisto_graphql()->authorize();

        $query->distinct()
            ->select('wishlist_items.*')
            ->leftJoin('product_flat', 'wishlist_items.product_id', '=', 'product_flat.product_id')
            ->where('wishlist_items.customer_id', $customer->id);

        $filters = [
            'wishlist_items.id'         => $input['id'] ?? null,
            'wishlist_items.product_id' => $input['product_id'] ?? null,
            'wishlist_items.channel_id' => $input['channel_id'] ?? null,
        ];

        $query = $this->applyFilter($query, $filters);

        $query->when(! empty($input['product_name']), function ($query) use ($input) {
            $query->where('product_flat.name', 'like', '%'.$input['product_name'].'%');
        });

        return $query;
    }

    /**
     * Get the specified wishlist item.
     */
    public function getItem(Builder $query): Builder
    {
        $customer = bagisto_graphql()->authorize();

        return $query->where('customer_id', $customer->id);
    }

    /**
     * Returns loggedin guest/customer's wishlist data.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getWishlists()
    {
        return $this->wishlistRepository->findWhere([
            'customer_id' => auth()->user()->id,
        ]);
    }
}
