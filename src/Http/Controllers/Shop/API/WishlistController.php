<?php

namespace Webkul\GraphQLAPI\Http\Controllers\Shop\API;

use Webkul\Checkout\Facades\Cart;
use Illuminate\Support\Facades\Event;
use Webkul\Shop\Http\Resources\CartResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Webkul\Shop\Http\Resources\WishlistResource;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Customer\Repositories\WishlistRepository;
use Webkul\Shop\Http\Controllers\API\WishlistController as WishlistControllerBase;

class WishlistController extends WishlistControllerBase
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected WishlistRepository $wishlistRepository,
        protected ProductRepository $productRepository
    ) {}

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

        if (! $this->wishlistRepository->findOneWhere($data)) {
            Event::dispatch('customer.wishlist.create.before', $productId);

            $wishlist = $this->wishlistRepository->create($data);

            Event::dispatch('customer.wishlist.create.after', $wishlist);

            return new JsonResource([
                'message' => trans('shop::app.customers.account.wishlist.success'),
            ]);
        }

        $this->wishlistRepository->deleteWhere([
            'product_id'  => $product->id,
            'customer_id' => auth()->guard()->user()->id,
        ]);

        return new JsonResource([
            'message' => trans('shop::app.customers.account.wishlist.removed'),
        ]);
    }

    /**
     * Move the wishlist item to the cart.
     *
     * @param  int  $id
     */
    public function moveToCart($id): JsonResource
    {
        $wishlistItem = $this->wishlistRepository->findOneWhere([
            'id'          => $id,
            'customer_id' => auth()->guard('customer')->user()->id,
        ]);

        if (! $wishlistItem) {
            abort(404);
        }

        try {
            Event::dispatch('customer.wishlist.move-to-cart.before', $id);

            $result = Cart::moveToCart($wishlistItem, request()->input('quantity'));

            Event::dispatch('customer.wishlist.move-to-cart.after', $id);

            if ($result) {
                return new JsonResource([
                    'data' => [
                        'wishlist' => WishlistResource::collection($this->wishlistRepository->get()),
                        'cart'     => new CartResource(Cart::getCart()),
                    ],

                    'message'  => trans('shop::app.customers.account.wishlist.moved-success'),
                ]);
            }

            return new JsonResource([
                'redirect' => true,
                'data'     => route('shop.product_or_category.index', $wishlistItem->product->url_key),
                'message'  => trans('shop::app.checkout.cart.missing-options'),
            ]);

        } catch (\Exception $exception) {
            return new JsonResource([
                'redirect' => true,
                'data'     => route('shop.product_or_category.index', $wishlistItem->product->url_key),
                'message'  => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Function to remove items to the wishlist.
     *
     * @param  int  $id
     */
    public function destroy($id): JsonResource
    {
        Event::dispatch('customer.wishlist.delete.before', $id);

        $success = $this->wishlistRepository->deleteWhere([
            'id'          => $id,
            'customer_id' => auth()->guard('customer')->user()->id,
        ]);

        Event::dispatch('customer.wishlist.delete.after', $id);

        if (! $success) {
            return new JsonResource([
                'message' => trans('shop::app.customers.account.wishlist.remove-fail'),
            ]);
        }

        return new JsonResource([
            'data'    => WishlistResource::collection($this->wishlistRepository->get()),
            'message' => trans('shop::app.customers.account.wishlist.removed'),
        ]);
    }

    /**
     * Method for removing all items from the wishlist.
     */
    public function destroyAll(): JsonResource
    {
        Event::dispatch('customer.wishlist.delete-all.before');

        $success = $this->wishlistRepository->deleteWhere([
            'customer_id'  => auth()->guard('customer')->user()->id,
        ]);

        Event::dispatch('customer.wishlist.delete-all.after');

        if (! $success) {
            return new JsonResource([
                'message'  => trans('shop::app.customers.account.wishlist.remove-fail'),
            ]);
        }

        return new JsonResource([
            'message'  => trans('shop::app.customers.account.wishlist.removed'),
        ]);
    }
}
