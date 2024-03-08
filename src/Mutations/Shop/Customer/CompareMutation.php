<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Http\Controllers\Controller;
use Webkul\Customer\Repositories\CompareItemRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Product\Repositories\ProductFlatRepository;
use Webkul\GraphQLAPI\Validators\Customer\CustomException;

class CompareMutation extends Controller
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
     * @param  \Webkul\Product\Repositories\ProductFlatRepository  $productFlatRepository
     * @return void
     */
    public function __construct(
        protected CompareItemRepository $compareItemRepository,
        protected ProductRepository $productRepository,
        protected ProductFlatRepository $productFlatRepository
    ) {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);

        $this->middleware('auth:'.$this->guard);
    }

    /**
     * Returns customer's compare product list
     *
     * @return \Illuminate\Http\Response
     */
    public function compareProducts($rootValue, array $args, GraphQLContext $context)
    {
        if (! bagisto_graphql()->guard($this->guard)->check()) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.customer.no-login-customer'),
                'Invalid request header parameter.'
            );
        }

        try {
            $params = isset($args['input']) ? $args['input'] : (isset($args['id']) ? $args : []);

            $currentPage = $params['page'] ?? 1;

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });

            $compareProducts = app(CompareItemRepository::class)->scopeQuery(function ($query) use ($params) {

                $customer = bagisto_graphql()->guard($this->guard)->user();

                $qb = $query->select('compare_items.*')
                    ->leftJoin('product_flat', 'compare_items.product_id', '=', 'product_flat.product_id')
                    ->leftJoin('customers','customers.id','=','compare_items.customer_id')
                    ->where('customers.id', $customer->id)
                    ->groupBy('compare_items.product_id');

                return $qb;
             });

             if (! empty($args['id'])) {
                $compareProducts = $compareProducts->first();
            } else {
                $compareProducts = $compareProducts->paginate(isset($params['limit']) ? $params['limit'] : 10);
            }

            if (($compareProducts && isset($compareProducts->first()->id)) || isset($compareProducts->id)) {
                return $compareProducts;
            }

            throw new CustomException(
                'You have no items in your compare list',
                'You have no items in your compare list'
            );
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
        if (empty($args['input'])) {
            throw new CustomException(
                trans('bagisto_graphql::app.admin.response.error-invalid-parameter'),
                trans('bagisto_graphql::app.admin.response.error-invalid-parameter')
            );
        }

        if (! bagisto_graphql()->guard($this->guard)->check()) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.customer.no-login-customer'),
                trans('bagisto_graphql::app.shop.customer.no-login-customer')
            );
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            throw new CustomException(
                $validator->messages(),
                $validator->messages()
            );
        }

        try {
            $compareProduct = $this->compareItemRepository->findOneByField([
                'customer_id' =>  bagisto_graphql()->guard($this->guard)->user()->id,
                'product_id'  => $data['product_id'],
            ]);

            if ($compareProduct) {
                return [
                    'success'        => trans('shop::app.compare.already-added'),
                    'compareProduct' => [$compareProduct],
                ];
            } else {
                $this->compareItemRepository->create([
                    'customer_id' => bagisto_graphql()->guard($this->guard)->user()->id,
                    'product_id'  => $data['product_id'],
                ]);

                return [
                    'success'        => trans('shop::app.compare.item-add-success'),
                    'compareProduct' => $this->compareItemRepository->findWhere(['customer_id' => bagisto_graphql()->guard($this->guard)->user()->id]),
                ];
            }
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
     * @param  array  $args
     * @return \Illuminate\Http\Response
     */
    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['input'])) {
            throw new CustomException(
                trans('bagisto_graphql::app.admin.response.error-invalid-parameter'),
                trans('bagisto_graphql::app.admin.response.error-invalid-parameter')
            );
        }

        if (! bagisto_graphql()->guard($this->guard)->check()) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.customer.no-login-customer'),
                trans('bagisto_graphql::app.shop.customer.no-login-customer')
            );
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            throw new CustomException(
                $validator->messages(),
                $validator->messages()
            );
        }

        try {
            $customer = bagisto_graphql()->guard($this->guard)->user();

            $compareProduct = $this->compareItemRepository->findOneWhere($data);

            if ($compareProduct) {
                $this->compareItemRepository->delete($compareProduct->id);

                return [
                    'status'         => true,
                    'success'        => trans('shop::app.compare.remove-success'),
                    'compareProduct' => $this->compareItemRepository->findWhere(['customer_id' => $customer->id]),
                ];
            } else {
                return [
                    'status'  => false,
                    'success' => trans('bagisto_graphql::app.shop.customer.account.not-found', ['name' => 'Compare Product']),
                ];
            }
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                $e->getMessage()
            );
        }
    }

    /**
     * Remove all the compare entries of customer.
     *
     * @param  array  $args
     * @return \Illuminate\Http\Response
     */
    public function deleteAll($rootValue, array $args, GraphQLContext $context)
    {
        if (! bagisto_graphql()->guard($this->guard)->check()) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.customer.no-login-customer'),
                trans('bagisto_graphql::app.shop.customer.no-login-customer')
            );
        }

        try {
            $this->compareItemRepository->deleteWhere([
                'customer_id' => bagisto_graphql()->guard($this->guard)->user()->id,
            ]);

            return [
                'status'  => true,
                'success' => trans('shop::app.compare.remove-all-success'),
            ];
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                $e->getMessage()
            );
        }
    }
}
