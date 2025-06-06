<?php

namespace Webkul\GraphQLAPI;

use Illuminate\Support\Facades\Event;
use Webkul\Checkout\Repositories\CartAddressRepository;
use Webkul\Checkout\Repositories\CartItemRepository;
use Webkul\Checkout\Repositories\CartRepository;
use Webkul\Customer\Contracts\Wishlist as WishlistContract;
use Webkul\Customer\Repositories\CustomerAddressRepository;
use Webkul\Customer\Repositories\WishlistRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Tax\Repositories\TaxCategoryRepository;
use Webkul\Checkout\Cart as BaseCart;

class Cart extends BaseCart
{
    /**
     * Create a new class instance.
     *
     * @return void
     */
    public function __construct(
        protected CartRepository $cartRepository,
        protected CartItemRepository $cartItemRepository,
        protected CartAddressRepository $cartAddressRepository,
        protected ProductRepository $productRepository,
        protected TaxCategoryRepository $taxCategoryRepository,
        protected WishlistRepository $wishlistRepository,
        protected CustomerAddressRepository $customerAddressRepository
    ) {
        $this->initCart();
    }

    /**
     * Move a wishlist item to cart.
     */
    public function moveToCart(WishlistContract $wishlistItem, ?int $quantity = 1): bool
    {
        if (! $wishlistItem->product->getTypeInstance()->canBeMovedFromWishlistToCart($wishlistItem)) {
            return false;
        }

        if (! $wishlistItem->additional) {
            $wishlistItem->additional = ['product_id' => $wishlistItem->product_id];
        }

        $additional = [
            ...$wishlistItem->additional,
            'quantity' => $quantity,
        ];

        $result = $this->addProduct($wishlistItem->product, $additional);

        if ($result) {
            Event::dispatch('customer.wishlist.delete.before', $wishlistItem->id);

            $this->wishlistRepository->delete($wishlistItem->id);

            Event::dispatch('customer.wishlist.delete.after', $wishlistItem->id);

            return true;
        }

        return false;
    }

    /**
     * Move to wishlist items.
     */
    public function moveToWishlist(int $itemId, int $quantity = 1): bool
    {
        $cartItem = $this->cart->items()->find($itemId);

        if (! $cartItem) {
            return false;
        }

        $wishlistItems = $this->wishlistRepository->findWhere([
            'customer_id' => $this->cart->customer_id,
            'product_id'  => $cartItem->product_id,
        ]);

        $found = false;

        foreach ($wishlistItems as $wishlistItem) {
            $options = $wishlistItem->item_options;

            if (! $options) {
                $options = ['product_id' => $wishlistItem->product_id];
            }

            if ($cartItem->getTypeInstance()->compareOptions($cartItem->additional, $options)) {
                $found = true;
            }
        }

        if (! $found) {
            Event::dispatch('customer.wishlist.create.before', $cartItem->product_id);

            $wishlist = $this->wishlistRepository->create([
                'channel_id'  => $this->cart->channel_id,
                'customer_id' => $this->cart->customer_id,
                'product_id'  => $cartItem->product_id,
                'additional'  => [
                    ...$cartItem->additional,
                    'quantity' => $quantity,
                ],
            ]);

            Event::dispatch('customer.wishlist.create.after', $wishlist);
        }

        if (! $this->cart->items->count()) {
            $this->cartRepository->delete($this->cart->id);

            $this->refreshCart();
        } else {
            $this->cartItemRepository->delete($itemId);

            $this->refreshCart();

            $this->collectTotals();
        }

        return true;
    }
}
