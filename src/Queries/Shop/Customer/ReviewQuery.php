<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Customer;

use Webkul\Customer\Http\Controllers\Controller;

class ReviewQuery extends Controller
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
    public function __construct()
    {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);
        
        $this->middleware('auth:' . $this->guard);
    }

    /**
     * Returns loggedin customer's reviews data.
     *
     * @return \Illuminate\Http\Response
     */
    public function getReviews($query, $input, $test)
    {
        $params = $input;
        
        $channel = core()->getRequestedChannelCode();
        $locale = core()->getRequestedLocaleCode();

        if ( bagisto_graphql()->guard($this->guard)->check() && isset($params['customer_id']) ) {
            $params['customer_id'] = bagisto_graphql()->guard($this->guard)->user()->id;
        }
        
        $qb = $query->distinct()
            ->addSelect('product_reviews.*')
            ->addSelect('product_flat.name as product_name')
            ->leftJoin('product_flat', 'product_reviews.product_id', '=', 'product_flat.product_id')
            ->where('product_flat.channel', $channel)
            ->where('product_flat.locale', $locale);

        if ( isset($params['id']) && $params['id']) {
            $qb->where('product_reviews.id', $params['id']);
        }

        if ( isset($params['title']) && $params['title']) {
            $qb->where('product_reviews.title', 'like', '%' . urldecode($params['title']) . '%');
        }
        
        if ( isset($params['rating']) && $params['rating']) {
            $qb->where('product_reviews.rating', $params['rating']);
        }
        
        if ( isset($params['customer_id']) && $params['customer_id']) {
            $qb->where('product_reviews.customer_id', $params['customer_id']);
        }

        if ( isset($params['customer_name']) && $params['customer_name']) {
            $qb->where('product_reviews.name', 'like', '%' . urldecode($params['customer_name']) . '%');
        }

        if ( isset($params['product_name']) && $params['product_name']) {
            $qb->where('product_flat.name', 'like', '%' . urldecode($params['product_name']) . '%');
        }
        
        if ( isset($params['product_id']) && $params['product_id']) {
            $qb->where('product_reviews.product_id', $params['product_id']);
        }

        if ( isset($params['status']) && $params['status']) {
            $qb->where('product_reviews.status', $params['status']);
        }

        return $qb;
    }
}