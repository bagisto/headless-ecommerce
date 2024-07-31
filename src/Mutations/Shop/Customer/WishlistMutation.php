<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($args, [
            'product_id' => 'required|integer|exists:products,id',
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

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
            if (! $wishlist = $this->wishlistRepository->findOneWhere($data)) {
                $wishlist = $this->wishlistRepository->create($data);

                $wishlist->success = trans('bagisto_graphql::app.shop.customers.account.wishlist.success');

                return $wishlist;
            }

            $wishlist->success = trans('bagisto_graphql::app.shop.customers.account.wishlist.already-exist');

            return $wishlist;
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
        $validator = Validator::make($args, [
            'product_id' => 'required|integer|exists:products,id',
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

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
                    'success' => trans('bagisto_graphql::app.shop.customers.account.wishlist.remove-success'),
                ];
            }

            return [
                'success' => trans('bagisto_graphql::app.shop.customers.account.wishlist.not-found'),
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
        $validator = Validator::make($args, [
            'id'       => 'required|integer|exists:wishlist_items,id',
            'quantity' => 'required|integer',
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        $wishlistItem = $this->wishlistRepository->find($args['id']);

        if (! $wishlistItem) {
            return [
                'success' => trans('bagisto_graphql::app.shop.customers.account.wishlist.not-found'),
            ];
        }

        try {
            $result = Cart::moveToCart($wishlistItem, $args['quantity']);

            $message = $result
                ? trans('bagisto_graphql::app.shop.customers.account.wishlist.moved-success')
                : trans('shop::app.checkout.cart.missing-options');

            return [
                'success'  => $message,
                'wishlist' => $this->wishlistRepository->get(),
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
                    'success' => trans('bagisto_graphql::app.shop.customers.account.wishlist.not-found'),
                ];
            }

            $this->wishlistRepository->deleteWhere(['customer_id' => auth()->user()->id]);

            return [
                'success' => trans('bagisto_graphql::app.shop.customers.account.wishlist.remove-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
