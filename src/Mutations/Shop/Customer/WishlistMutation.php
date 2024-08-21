<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Checkout\Facades\Cart;
use Webkul\Customer\Repositories\WishlistRepository;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Product\Repositories\ProductRepository;

class WishlistMutation extends Controller
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
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $product = $this->productRepository->find($args['product_id']);

        if (! $product) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.wishlist.product-removed'));
        }

        $data = [
            'channel_id'  => core()->getCurrentChannel()->id,
            'product_id'  => $product->id,
            'customer_id' => auth()->user()->id,
        ];

        try {
            if ($this->wishlistRepository->findOneWhere($data)) {
                return [
                    'success'  => false,
                    'message'  => trans('bagisto_graphql::app.shop.customers.account.wishlist.already-exist'),
                    'wishlist' => $this->wishlistRepository->findWhere([
                        'customer_id' => auth()->user()->id,
                    ]),
                ];
            }

            $this->wishlistRepository->create($data);

            return [
                'success'  => true,
                'message'  => trans('bagisto_graphql::app.shop.customers.account.wishlist.success'),
                'wishlist' => $this->wishlistRepository->findWhere([
                    'customer_id' => auth()->user()->id,
                ]),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $product = $this->productRepository->find($args['product_id']);

        if (! $product) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.wishlist.product-removed'));
        }

        $data = [
            'channel_id'  => core()->getCurrentChannel()->id,
            'product_id'  => $product->id,
            'customer_id' => auth()->user()->id,
        ];

        try {
            if ($wishlist = $this->wishlistRepository->findOneWhere($data)) {
                $this->wishlistRepository->delete($wishlist->id);

                return [
                    'success'  => true,
                    'message'  => trans('bagisto_graphql::app.shop.customers.account.wishlist.remove-success'),
                    'wishlist' => $this->wishlistRepository->findWhere([
                        'customer_id' => auth()->user()->id,
                    ]),
                ];
            }

            return [
                'success'  => false,
                'message'  => trans('bagisto_graphql::app.shop.customers.account.wishlist.not-found'),
                'wishlist' => $this->wishlistRepository->findWhere([
                    'customer_id' => auth()->user()->id,
                ]),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Move wishlist item to cart
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function move($rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'id'       => 'required|integer|exists:wishlist_items,id',
            'quantity' => 'required|integer',
        ]);

        $wishlistItem = $this->wishlistRepository->findOneWhere([
            'id'          => $args['id'],
            'customer_id' => auth()->user()->id,
        ]);

        if (! $wishlistItem) {
            return [
                'success'  => false,
                'message'  => trans('bagisto_graphql::app.shop.customers.account.wishlist.not-found'),
                'wishlist' => $this->wishlistRepository->findWhere([
                    'customer_id' => auth()->user()->id,
                ]),
            ];
        }

        try {
            $result = Cart::moveToCart($wishlistItem, $args['quantity']);

            return [
                'success'  => $result ? true : false,
                'message'  => $result
                    ? trans('bagisto_graphql::app.shop.customers.account.wishlist.moved-success')
                    : trans('shop::app.checkout.cart.missing-options'),
                'wishlist' => $this->wishlistRepository->findWhere([
                    'customer_id' => auth()->user()->id,
                ]),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Remove all the wishlist entries of customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll($rootValue, array $args, GraphQLContext $context)
    {
        try {
            if (empty(auth()->user()->wishlist_items)) {
                return [
                    'success' => false,
                    'message' => trans('bagisto_graphql::app.shop.customers.account.wishlist.not-found'),
                ];
            }

            $this->wishlistRepository->deleteWhere(['customer_id' => auth()->user()->id]);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.shop.customers.account.wishlist.remove-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
