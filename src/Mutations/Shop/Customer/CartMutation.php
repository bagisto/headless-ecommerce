<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Exception;
use Webkul\Checkout\Facades\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Webkul\Shipping\Facades\Shipping;
use Webkul\Checkout\Repositories\CartRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Checkout\Repositories\CartItemRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Validators\Customer\CustomException;

class CartMutation extends Controller
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
     * @param  \Webkul\Checkout\Repositories\CartRepository  $cartRepository
     * @param  \Webkul\Checkout\Repositories\CartItemRepository  $cartItemRepository
     * @param  \Webkul\Product\Repositories\ProductRepository  $productRepository
     * @return void
     */
    public function __construct(
       protected CartRepository $cartRepository,
       protected CartItemRepository $cartItemRepository,
       protected ProductRepository $productRepository
    )
    {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);

        $this->middleware('auth:' . $this->guard);
    }

    /**
     * Returns a current cart detail.
     *
     * @return \Illuminate\Http\Response
     */
    public function cart($rootValue, array $args , GraphQLContext $context)
    {
        try {
            return Cart::getCart();
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                $e->getMessage()
            );
        }
    }

    /**
     * Returns a current cart's detail.
     *
     * @return \Illuminate\Http\Response
     */
    public function cartItems($rootValue, array $args , GraphQLContext $context)
    {
        try {
            $cart = Cart::getCart();

            return $cart ? $cart->items : [];
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                $e->getMessage()
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (
            ! isset($args['input'])
            || (
                isset($args['input'])
                && ! $args['input']
            )
        ) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.checkout.cart.item.error-invalid-parameter'),
                trans('bagisto_graphql::app.shop.checkout.cart.item.error-invalid-parameter')
            );
        }

        $data = $args['input'];

        if (
            ! isset($data['product_id'])
            || (
                isset($data['product_id'])
                && ! $data['product_id']
            )
        ) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.checkout.cart.item.error-invalid-parameter'),
                trans('bagisto_graphql::app.shop.checkout.cart.item.error-invalid-parameter')
            );
        }

        try {
            $product = $this->productRepository->findOrFail($data['product_id']);

            $data = bagisto_graphql()->manageInputForCart($product, $data);

            $cart = Cart::addProduct($data['product_id'], $data);

            if (isset($cart->id)) {
                return [
                    'status'  => true,
                    'message' => trans('bagisto_graphql::app.shop.checkout.cart.item.success-add-to-cart'),
                    'cart'    => $cart,
                ];
            }

            return [
                'status'  => true,
                'message' => trans('bagisto_graphql::app.shop.checkout.cart.item.fail-add-to-cart'),
                'cart'    => $cart,
            ];
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(), $e->getMessage(),
                $e->getMessage(), $e->getMessage()
            );
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
        if (
            ! isset($args['input'])
            || (
                isset($args['input'])
                && ! $args['input']
            )
        ) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.checkout.cart.item.error-invalid-parameter'),
                trans('bagisto_graphql::app.shop.checkout.cart.item.error-invalid-parameter')
            );
        }

        $data = $args['input'];

        if (
            ! isset($data['qty'])
            || (
                isset($data['qty'])
                && ! $data['qty']
            )
        ) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.checkout.cart.item.error-invalid-parameter'),
                trans('bagisto_graphql::app.shop.checkout.cart.item.error-invalid-parameter')
            );
        }

        try {
            $qty = [];

            foreach ($data['qty'] as $item) {
                if (
                    isset($item['cart_item_id'])
                    && $item['quantity']
                ) {
                    $qty[$item['cart_item_id']] = $item['quantity'];
                }
            }

            $data['qty'] = $qty;

            if (Cart::updateItems($data)) {
                return [
                    'status'  => true,
                    'message' => trans('bagisto_graphql::app.shop.checkout.cart.item.success-update-to-cart'),
                    'cart'    => Cart::getCart(),
                ];
            }

            return [
                'status'  => false,
                'message' => trans('bagisto_graphql::app.shop.checkout.cart.item.fail-update-to-cart'),
                'cart'    => Cart::getCart(),
            ];
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                $e->getMessage()
            );
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
        if (
            ! isset($args['id'])
            || (
                isset($args['id'])
                && ! $args['id']
            )
        ) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.checkout.cart.item.error-invalid-parameter'),
                trans('bagisto_graphql::app.shop.checkout.cart.item.error-invalid-parameter')
            );
        }

        try {
            $cartItem = $this->cartItemRepository->find($args['id']);

            if ($cartItem) {
                Event::dispatch('checkout.cart.delete.before', $args['id']);

                Shipping::removeAllShippingRates();

                $this->cartItemRepository->delete($cartItem->id);

                Event::dispatch('checkout.cart.delete.after', $args['id']);

                return [
                    'status'  => true,
                    'message' => trans('bagisto_graphql::app.shop.checkout.cart.item.success-delete-cart-item'),
                    'cart'    => Cart::getCart(),
                ];
            }

            return [
                'status'  => true,
                'message' => trans('bagisto_graphql::app.shop.checkout.cart.item.fail-delete-cart-item'),
                'cart'    => Cart::getCart(),
            ];
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                $e->getMessage()
            );
        }
    }

    /**
     * Remove all resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll($rootValue, array $args, GraphQLContext $context)
    {
        try {
            if ($cart = Cart::getCart()) {
                Event::dispatch('checkout.cart.delete.all.before', $cart);

                $this->cartRepository->delete($cart->id);

                Cart::resetCart();

                Event::dispatch('checkout.cart.delete.all.after', $cart);

                return [
                    'status'  => true,
                    'message' => trans('bagisto_graphql::app.shop.checkout.cart.item.success-all-remove'),
                    'cart'    => $cart,
                ];
            }

            return [
                'status'  => false,
                'message' => trans('bagisto_graphql::app.shop.checkout.cart.item.fail-all-remove'),
                'cart'    => $cart,
            ];
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                $e->getMessage()
            );
        }
    }

    /**
     * Move the specified resource to Wishlist.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function move($rootValue, array $args, GraphQLContext $context)
    {
        if (
            ! isset($args['id'])
            || (
                isset($args['id'])
                && ! $args['id']
            )
        ) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.checkout.cart.item.error-invalid-parameter'),
                trans('bagisto_graphql::app.shop.checkout.cart.item.error-invalid-parameter')
            );
        }

        try {
            if (Cart::moveToWishlist($args['id'])) {
                return [
                    'status'  => true,
                    'message' => trans('bagisto_graphql::app.shop.checkout.cart.item.success-moved-cart-item'),
                    'cart'    => Cart::getCart(),
                ];
            }

            return [
                'status'  => false,
                'message' => trans('bagisto_graphql::app.shop.checkout.cart.item.fail-moved-cart-item'),
                'cart'    => Cart::getCart(),
            ];
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                $e->getMessage()
            );
        }
    }
}
