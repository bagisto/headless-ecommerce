<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Repositories\CartItemRepository;
use Webkul\Checkout\Repositories\CartRepository;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Product\Repositories\ProductRepository;

class CartMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CartRepository $cartRepository,
        protected CartItemRepository $cartItemRepository,
        protected ProductRepository $productRepository
    ) {
        Auth::setDefaultDriver('api');

        $this->middleware('auth:api');
    }

    /**
     * Returns a current cart detail.
     *
     * @return \Illuminate\Http\Response
     */
    public function cart($rootValue, array $args, GraphQLContext $context)
    {
        try {
            return Cart::getCart();
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Returns a current cart's detail.
     *
     * @return \Illuminate\Http\Response
     */
    public function cartItems($rootValue, array $args, GraphQLContext $context)
    {
        try {
            $cart = Cart::getCart();

            return $cart?->items ?? [];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'quantity'   => 'required|min:1',
            'product_id' => 'required|integer|exists:products,id',
        ]);

        try {
            $product = $this->productRepository->findOrFail($args['product_id']);

            $data = bagisto_graphql()->manageInputForCart($product, $args);

            $cart = Cart::addProduct($product, $data);

            return [
                'status'  => ! empty($cart),
                'message' => ! empty($cart)
                                ? trans('bagisto_graphql::app.shop.checkout.cart.item.success.add-to-cart')
                                : trans('bagisto_graphql::app.shop.checkout.cart.item.fail.add-to-cart'),
                'cart' => $cart,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($rootValue, array $args, GraphQLContext $context)
    {
        $data = $args['input'];

        bagisto_graphql()->validate($data, [
            'qty'                => 'required|array',
            'qty.*.cart_item_id' => 'required|integer|exists:cart_items,id',
            'qty.*.quantity'     => 'required|integer|min:1',
        ]);

        try {
            $qty = [];

            foreach ($data['qty'] as $item) {
                if (! $this->cartItemRepository->find($item['cart_item_id'])) {
                    throw new CustomException(trans('bagisto_graphql::app.shop.checkout.cart.item.fail.item-not-found'));
                }

                $qty[$item['cart_item_id']] = $item['quantity'] ?: 1;
            }

            $data['qty'] = $qty;

            $cartUpdated = Cart::updateItems($data);

            return [
                'status'  => $cartUpdated,
                'message' => $cartUpdated
                                ? trans('bagisto_graphql::app.shop.checkout.cart.item.success.update-to-cart')
                                : trans('bagisto_graphql::app.shop.checkout.cart.item.fail.update-to-cart'),
                'cart' => Cart::getCart(),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'id' => 'required|integer|exists:cart_items,id',
        ]);

        try {
            $isRemoved = Cart::removeItem($args['id']);

            Cart::collectTotals();

            return [
                'status'  => $isRemoved,
                'message' => $isRemoved
                                ? trans('bagisto_graphql::app.shop.checkout.cart.item.success.delete-cart-item')
                                : trans('bagisto_graphql::app.shop.checkout.cart.item.fail.delete-cart-item'),
                'cart'    => Cart::getCart(),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Remove all resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll($rootValue, array $args, GraphQLContext $context)
    {
        $cart = Cart::getCart();

        if (! $cart) {
            throw new CustomException(trans('bagisto_graphql::app.shop.checkout.cart.item.fail.not-found'));
        }

        try {
            Event::dispatch('checkout.cart.delete.all.before', $cart);

            $isDeleted = $this->cartRepository->delete($cart->id);

            Cart::resetCart();

            Event::dispatch('checkout.cart.delete.all.after', $cart);

            return [
                'status'  => $isDeleted,
                'message' => $isDeleted
                                ? trans('bagisto_graphql::app.shop.checkout.cart.item.success.all-remove')
                                : trans('bagisto_graphql::app.shop.checkout.cart.item.fail.all-remove'),
                'cart'    => Cart::getCart(),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Move the specified resource to Wishlist.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function moveToWishlist($rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'id' => 'required|integer|exists:cart_items,id',
        ]);

        try {
            $isMoved = Cart::moveToWishlist($args['id']);

            return [
                'status'  => $isMoved,
                'message' => $isMoved
                                ? trans('bagisto_graphql::app.shop.checkout.cart.item.success.move-to-wishlist')
                                : trans('bagisto_graphql::app.shop.checkout.cart.item.fail.move-to-wishlist'),
                'cart'    => Cart::getCart(),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
