<?php

namespace Webkul\GraphQLAPI\Http\Controllers\Shop\API;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Event;
use Webkul\Shop\Http\Controllers\API\WishlistController as BaseWishlistController;

class WishlistController extends BaseWishlistController
{
    /**
     * Function to add items to the wishlist.
     */
    public function store(): JsonResource
    {
        $this->validate(request(), [
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $productId = request()->input('product_id');

        $product = $this->productRepository->find($productId);

        if (! $product) {
            return new JsonResource([
                'message' => trans('shop::app.customers.account.wishlist.product-removed'),
            ]);
        }

        $data = [
            'channel_id'  => core()->getCurrentChannel()->id,
            'product_id'  => $product->id,
            'customer_id' => auth()->guard()->user()->id,
        ];

        if (! $wishlist = $this->wishlistRepository->findOneWhere($data)) {
            Event::dispatch('customer.wishlist.create.before', $productId);

            $wishlist = $this->wishlistRepository->create($data);

            Event::dispatch('customer.wishlist.create.after', $wishlist);

            return new JsonResource([
                'message' => trans('shop::app.customers.account.wishlist.success'),
            ]);
        }

        Event::dispatch('customer.wishlist.delete.before', $wishlist->id);

        $this->wishlistRepository->deleteWhere([
            'product_id'  => $product->id,
            'customer_id' => auth()->guard()->user()->id,
        ]);

        Event::dispatch('customer.wishlist.delete.after', $wishlist->id);

        return new JsonResource([
            'message' => trans('shop::app.customers.account.wishlist.removed'),
        ]);
    }
}
