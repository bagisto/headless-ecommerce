<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Customer;

use App\Http\Controllers\Controller;
use Webkul\Customer\Repositories\WishlistRepository;

class WishlistQuery extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected WishlistRepository $wishlistRepository)
    {
    }

    /**
     * filter the data .
     *
     * @param  object  $query
     * @param  array $input
     * @return \Illuminate\Http\Response
     */
    public function __invoke($query, $input)
    {
        if (! is_array($input)) {
            $input = ['id' => $input];
        }

        $input['customer_id'] = auth()->guard()->user()->id;
        
        return $query->where($input);
    }

    /**
     * Returns loggedin guest/customer's wishlist data.
     *
     * @return \Illuminate\Http\Response
     */
    public function getWishlists()
    {
        return $this->wishlistRepository->findWhere([
            'customer_id' => auth()->guard()->user()->id,
        ]);
    }

    /**
     * This function retrieves additional data for each item in the wishlist.
     *
     * @param  object  $query
     * @return \Illuminate\Support\Collection
     */
    public function getAdditionData($query)
    {
        // The get() method retrieves all records from the database.
        // The map() method iterates through each item in the collection, 
        // allowing us to transform the item's value and key.
        // The flatten() method is used to flatten a multi-dimensional collection into a single dimension.
        return $query->get()->map(function ($wishlistItem) {
            return collect($wishlistItem->additional)->transform(function ($additional, $key) {
                return [
                    'key'   => $key,
                    'value' => $additional,
                ];
            })->all();
        })->flatten(1);
    }
}
