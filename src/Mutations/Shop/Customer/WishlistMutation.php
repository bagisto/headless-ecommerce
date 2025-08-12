<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
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
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
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

            Event::dispatch('customer.wishlist.create.before', $product->id);

            $wishlist = $this->wishlistRepository->create($data);

            Event::dispatch('customer.wishlist.create.after', $wishlist);

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
     * @return array
     *
     * @throws CustomException
     */
    public function delete(mixed $rootValue, array $args, GraphQLContext $context)
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
                $wishlistId = $wishlist->id;

                Event::dispatch('customer.wishlist.delete.before', $wishlistId);

                $this->wishlistRepository->delete($wishlistId);

                Event::dispatch('customer.wishlist.delete.after', $wishlistId);

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
     * @return array
     *
     * @throws CustomException
     */
    public function move(mixed $rootValue, array $args, GraphQLContext $context)
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
            Event::dispatch('customer.wishlist.move-to-cart.before', $args['id']);

            $result = Cart::moveToCart($wishlistItem, $args['quantity']);

            Event::dispatch('customer.wishlist.move-to-cart.after', $args['id']);

            return [
                'success'  => $result ? true : false,
                'message'  => $result
                    ? trans('bagisto_graphql::app.shop.customers.account.wishlist.moved-to-cart')
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
     * @return array
     *
     * @throws CustomException
     */
    public function deleteAll(mixed $rootValue, array $args, GraphQLContext $context)
    {
        try {
            if (! count(auth()->user()->wishlist_items)) {
                return [
                    'success' => false,
                    'message' => trans('bagisto_graphql::app.shop.customers.account.wishlist.not-found'),
                ];
            }

            Event::dispatch('customer.wishlist.delete-all.before');

            $this->wishlistRepository->deleteWhere(['customer_id' => auth()->user()->id]);

            Event::dispatch('customer.wishlist.delete-all.after');

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.shop.customers.account.wishlist.remove-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
