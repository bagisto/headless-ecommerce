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
    public function __construct(
        protected WishlistRepository $wishlistRepository
    )
    {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);
        
        $this->middleware('auth:' . $this->guard);
    }

    /**
     * Returns loggedin guest/customer's wishlist data.
     *
     * @return \Illuminate\Http\Response
     */
    public function getWishlists($query, $input, $test)
    {
        $params = $input;

        if ( bagisto_graphql()->guard($this->guard)->check() ) {
            $params['customer_id'] = bagisto_graphql()->guard($this->guard)->user()->id;
        }
                    
        $items = $this->wishlistRepository
            ->where([
                'channel_id'  => core()->getCurrentChannel()->id,
                'customer_id' =>  $params['customer_id'],
            ])
            ->get();
            
        return $items;
    }
}