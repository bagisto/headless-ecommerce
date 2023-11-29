<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Exception;
use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Repositories\CartRepository;
use Webkul\Product\Repositories\ProductRepository;

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
     * @param  \Webkul\Product\Repositories\ProductRepository  $productRepository
     * @return void
     */
    public function __construct(
       protected CartRepository $cartRepository,
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
            throw new Exception($e->getMessage());
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
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['input']) || 
            (isset($args['input']) && ! $args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];

        if (! isset($data['product_id']) || 
            (isset($data['product_id']) && ! $data['product_id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }
        
        try {
            $product = $this->productRepository->findOrFail($data['product_id']);
            $data = bagisto_graphql()->manageInputForCart($product, $data);
            $cart = Cart::addProduct($data['product_id'], $data);
            
            if ( isset($cart->id)) {
                return [
                    'status'    => true,
                    'message'   => trans('bagisto_graphql::app.shop.response.success-add-to-cart'),
                    'cart'      => $cart,
                ];
            } else {
                return $cart;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
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
        if (! isset($args['input']) || 
            (isset($args['input']) && ! $args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];

        if (! isset($data['qty']) || 
            (isset($data['qty']) && ! $data['qty'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }
        
        try {
            $qty = [];
            foreach ($data['qty'] as $item) {
                if (isset($item['cart_item_id']) && $item['quantity']) {
                    $qty[$item['cart_item_id']] = $item['quantity'];
                }
            }

            $data['qty'] = $qty;
            $result = Cart::updateItems($data);
            if ($result == true) {
                return [
                    'status'    => true,
                    'message'   => trans('bagisto_graphql::app.shop.response.success-update-to-cart'),
                    'cart'      => Cart::getCart(),
                ];
            } else {
                return $result;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
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
        if (! isset($args['id']) || 
            (isset($args['id']) && ! $args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $cartItemId = $args['id'];
        
        try {
            $result = Cart::removeItem($cartItemId);
            if ($result == true) {

                return [
                    'status'    => true,
                    'message'   => trans('bagisto_graphql::app.shop.response.success-delete-cart-item'),
                    'cart'      => Cart::getCart(),
                ];
            } else {
                return $result;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
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
            $result = Cart::removeAllItems();

            $cart = Cart::getCart();
            
            if ($result) {
                return [
                    'status'    => true,
                    'message'   => trans('shop::app.checkout.cart.item.success-all-remove'),
                    'cart'      => $cart,
                ];
            }
            
            return [
                'status'    => false,
                'message'   => trans('velocity::app.error.something_went_wrong'),
                'cart'      => $cart,
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
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
        if (! isset($args['id']) || 
            (isset($args['id']) && ! $args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $cartItemId = $args['id'];
        
        try {
            $result = Cart::moveToWishlist($cartItemId);
            
            if ( $result == true) {

                return [
                    'status'    => true,
                    'message'   => trans('bagisto_graphql::app.shop.response.success-moved-cart-item'),
                    'cart'      => Cart::getCart(),
                ];
            } else {
                return $result;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}