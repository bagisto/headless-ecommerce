<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Customer\Repositories\CompareItemRepository;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Product\Repositories\ProductRepository;

class CompareMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected ProductRepository $productRepository,
        protected CompareItemRepository $compareItemRepository
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
        $customer = bagisto_graphql()->authorize();

        bagisto_graphql()->validate($args, [
            'product_id' => 'required',
        ]);

        $product = $this->productRepository->find($args['product_id']);

        if (! $product) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.compare-product.product-not-found'));
        }

        try {
            $compareProduct = $this->compareItemRepository->findOneByField([
                'customer_id' => $customer->id,
                'product_id'  => $product->id,
            ]);

            if ($compareProduct) {
                return [
                    'success'        => true,
                    'message'        => trans('bagisto_graphql::app.shop.customers.compare-product.already-added'),
                    'compareProduct' => $compareProduct,
                ];
            } else {
                Event::dispatch('customer.compare.create.before');

                $compareProduct = $this->compareItemRepository->create([
                    'customer_id' => $customer->id,
                    'product_id'  => $product->id,
                ]);

                Event::dispatch('customer.compare.create.after', $compareProduct);

                return [
                    'success'        => true,
                    'message'        => trans('bagisto_graphql::app.shop.customers.compare-product.item-add-success'),
                    'compareProduct' => $compareProduct,
                ];
            }
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
        $customer = bagisto_graphql()->authorize();

        bagisto_graphql()->validate($args, [
            'product_id' => 'required',
        ]);

        $compareProduct = $this->compareItemRepository->findOneWhere([
            'customer_id' => $customer->id,
            'product_id'  => $args['product_id'],
        ]);

        if (! $compareProduct) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.compare-product.not-found'));
        }

        try {
            Event::dispatch('customer.compare.delete.before', $args['product_id']);

            $compareProduct->delete();

            Event::dispatch('customer.compare.delete.after', $args['product_id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.shop.customers.compare-product.remove-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Remove all the compare entries of customer.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function deleteAll(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $customer = bagisto_graphql()->authorize();

        try {
            $compareProducts = $this->compareItemRepository->findWhere([
                'customer_id' => $customer->id,
            ]);

            if (! count($compareProducts)) {
                throw new CustomException(trans('bagisto_graphql::app.shop.customers.compare-product.not-found'));
            }

            Event::dispatch('customer.compare.delete-all.before');

            $this->compareItemRepository->deleteWhere([
                'customer_id' => $customer->id,
            ]);

            Event::dispatch('customer.compare.delete-all.after');

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.shop.customers.compare-product.mass-remove-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
