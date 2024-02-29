<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Customer;

use App\Http\Controllers\Controller;
use Webkul\Customer\Repositories\WishlistRepository;

class WishlistQuery extends Controller
{
    /**
     * Contains current guard
     *
     * @var array
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected WishlistRepository $wishlistRepository)
    {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);

        $this->middleware('auth:'.$this->guard);
    }

    /**
     * Returns loggedin guest/customer's wishlist data.
     *
     * @return \Illuminate\Http\Response
     */
    public function getWishlists($query, $input, $test)
    {
        $params = $input;

        $channel = core()->getRequestedChannelCode();
        $locale = core()->getRequestedLocaleCode();

        if (bagisto_graphql()->guard($this->guard)->check() ) {
            $params['customer_id'] = bagisto_graphql()->guard($this->guard)->user()->id;
        }

        $qb = $query->distinct()
        ->addSelect('wishlist_items.*')
        ->addSelect('product_flat.name as product_name')
        ->leftJoin('product_flat', 'wishlist_items.product_id', '=', 'product_flat.product_id')
        ->where('product_flat.channel', $channel)
        ->where('product_flat.locale', $locale);

        if (isset($params['id']) && $params['id']) {
            $qb->where('wishlist_items.id', $params['id']);
        }

        if (isset($params['product_name']) && $params['product_name']) {
            $qb->where('product_flat.name', 'like', '%'.urldecode($params['product_name']).'%');
        }

        if (isset($params['product_id']) && $params['product_id']) {
            $qb->where('wishlist_items.product_id', $params['product_id']);
        }

        if (isset($params['channel_id']) && $params['channel_id']) {
            $qb->where('wishlist_items.channel_id', $params['channel_id']);
        }

        if (isset($params['customer_id']) && $params['customer_id']) {
            $qb->where('wishlist_items.customer_id', $params['customer_id']);
        }

        return $qb;;
    }

    /**
     * Returns loggedin guest/customer's wishlist data.
     *
     * @return \Illuminate\Http\Response
     */
    public function getWishlist($query, $input, $test)
    {
        $params = $input;

        $channel = core()->getRequestedChannelCode();
        $locale = core()->getRequestedLocaleCode();

        if (bagisto_graphql()->guard($this->guard)->check() ) {
            $params['customer_id'] = bagisto_graphql()->guard($this->guard)->user()->id;
        }

        $qb = $query->distinct()
        ->addSelect('wishlist_items.*')
        ->addSelect('product_flat.name as product_name')
        ->leftJoin('product_flat', 'wishlist_items.product_id', '=', 'product_flat.product_id')
        ->where('product_flat.channel', $channel)
        ->where('product_flat.locale', $locale);

        if (isset($params['id']) && $params['id']) {
            $qb->where('wishlist_items.id', $params['id']);
        }

        if (isset($params['product_name']) && $params['product_name']) {
            $qb->where('product_flat.name', 'like', '%'.urldecode($params['product_name']).'%');
        }

        if (isset($params['product_id']) && $params['product_id']) {
            $qb->where('wishlist_items.product_id', $params['product_id']);
        }

        if (isset($params['channel_id']) && $params['channel_id']) {
            $qb->where('wishlist_items.channel_id', $params['channel_id']);
        }

        if (isset($params['customer_id']) && $params['customer_id']) {
            $qb->where('wishlist_items.customer_id', $params['customer_id']);
        }

        return $qb;;
    }
}
