<?php

namespace Webkul\GraphQLAPI\Http\Controllers\Admin\Customers\Customer;

use Illuminate\Support\Facades\Event;
use Illuminate\Http\Resources\Json\JsonResource;
use Webkul\Customer\Repositories\WishlistRepository;
use Webkul\Admin\Http\Controllers\Customers\Customer\WishlistController as WishlistControllerBase;

class WishlistController extends WishlistControllerBase
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected WishlistRepository $wishlistRepository) {}

    /**
     * Removes the item from the cart if it exists.
     */
    public function destroy(int $id): JsonResource
    {
        $this->validate(request(), [
            'item_id' => 'required|exists:wishlist_items,id',
        ]);
        
        $itemId = request()->input('item_id');

        Event::dispatch('customer.wishlist.delete.before', $itemId);

        $this->wishlistRepository->delete(request()->input('item_id'));

        Event::dispatch('customer.wishlist.delete.after', $itemId);

        return new JsonResource([
            'message' => trans('admin::app.customers.customers.view.wishlist.delete-success'),
        ]);
    }
}
