<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\Paginator;
use Webkul\Shop\Http\Controllers\Controller;
use Webkul\Product\Repositories\ProductFlatRepository;
use Webkul\Velocity\Repositories\VelocityCustomerCompareProductRepository as CompareProductsRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CompareMutation extends Controller
{
    /**
     * Contains current guard
     *
     * @var array
     */
    protected $guard;

    /**
     * ProductFlatRepository object
     *
     * @var \Webkul\Product\Repositories\ProductFlatRepository
     */
    protected $productFlatRepository;

    /**
     * CompareProductsRepository object
     *
     * @var \Webkul\Velocity\Repositories\VelocityCustomerCompareProductRepository $compareProductsRepository 
     */
    protected $compareProductsRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Product\Repositories\ProductFlatRepository  $productFlatRepository
     * @return void
     */
    public function __construct(
        ProductFlatRepository $productFlatRepository,
        CompareProductsRepository $compareProductsRepository
    ) {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);
        
        $this->middleware('auth:' . $this->guard);
        
        $this->productFlatRepository = $productFlatRepository;
        
        $this->compareProductsRepository = $compareProductsRepository;
    }

    /**
     * Returns customer's compare product list
     *
     * @return \Illuminate\Http\Response
     */
    public function compareProducts($rootValue, array $args , GraphQLContext $context)
    {
        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        if (! bagisto_graphql()->guard($this->guard)->check() ) {
            throw new Exception(trans('bagisto_graphql::app.shop.customer.no-login-customer'));
        }

        try {
            $params = isset($args['input']) ? $args['input'] : (isset($args['id']) ? $args : []);

            $currentPage = isset($params['page']) ? $params['page'] : 1;
            
            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });

            $compareProducts = app(CompareProductsRepository::class)->scopeQuery(function ($query) use ($params) {
                $channel = isset($params['channel']) ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

                $locale = isset($params['locale']) ?: app()->getLocale();

                $customer = bagisto_graphql()->guard($this->guard)->user();
                    
                $qb = $query->distinct()
                    ->addSelect('velocity_customer_compare_products.*')
                    ->leftJoin('product_flat', 'velocity_customer_compare_products.product_flat_id', '=', 'product_flat.id')
                    ->where('product_flat.channel', $channel)
                    ->where('product_flat.locale', $locale)
                    ->where('velocity_customer_compare_products.customer_id', $customer->id);

                if ( isset($params['id']) && $params['id']) {
                    $qb->where('velocity_customer_compare_products.id', $params['id']);
                }

                if ( isset($params['product_flat_id']) && $params['product_flat_id']) {
                    $qb->where('velocity_customer_compare_products.product_flat_id', $params['product_flat_id']);
                }

                if ( isset($params['product_name']) && $params['product_name']) {
                    $qb->where('product_flat.name', 'like', '%' . urldecode($params['product_name']) . '%');
                }
                
                if ( isset($params['price']) && $params['price']) {
                    $qb->where([
                        ['product_flat.min_price', '>=', core()->convertToBasePrice($params['price'])],
                        ['product_flat.min_price', '<=', core()->convertToBasePrice($params['price'])]
                    ]);
                }

                return $qb;
            });

            if ( isset($args['id'])) {
                $compareProducts = $compareProducts->first();
            } else {
                $compareProducts = $compareProducts->paginate( isset($params['limit']) ? $params['limit'] : 10);
            }
            
            if ( ($compareProducts && isset($compareProducts->first()->id)) || isset($compareProducts->id) ) {
                return $compareProducts;
            } else {
                throw new Exception(trans('bagisto_graphql::app.shop.response.not-found', ['name'   => 'Compare Product']));
            }
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
        if (! isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        if (! bagisto_graphql()->guard($this->guard)->check() ) {
            throw new Exception(trans('bagisto_graphql::app.shop.customer.no-login-customer'));
        }

        $data = $args['input'];
        
        $validator = \Validator::make($data, [
            'product_flat_id'    => 'required',
        ]);
        
        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $customer = bagisto_graphql()->guard($this->guard)->user();

            $productFlat = $this->productFlatRepository->findOrFail($data['product_flat_id']);
    
            if (! $productFlat->status) {
                throw new Exception(trans('bagisto_graphql::app.shop.response.invalid-product'));
            }

            $data['customer_id'] = $customer->id;

            $compareProduct = $this->compareProductsRepository->findOneWhere($data);

            if ( isset($compareProduct->id) && $compareProduct->id) {

                return [
                    'success'           => trans('velocity::app.customer.compare.already_added'),
                    'compareProduct'  => $compareProduct
                ];
            } else {
                $compareProduct = $this->compareProductsRepository->create($data);

                return [
                    'success'           => trans('velocity::app.customer.compare.added'),
                    'compareProduct'    => $compareProduct
                ];
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
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
        if (! isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        if (! bagisto_graphql()->guard($this->guard)->check() ) {
            throw new Exception(trans('bagisto_graphql::app.shop.customer.no-login-customer'));
        }

        $data = $args['input'];
        
        $validator = \Validator::make($data, [
            'product_flat_id'    => 'required',
        ]);
        
        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $customer = bagisto_graphql()->guard($this->guard)->user();

            $data['customer_id'] = $customer->id;

            $compareProduct = $this->compareProductsRepository->findOneWhere($data);

            if ( isset($compareProduct->id) && $compareProduct->id) {
                $this->compareProductsRepository->delete($compareProduct->id);
                return [
                    'status'    => true,
                    'success'   => trans('velocity::app.customer.compare.removed'),
                ];
            } else {
                return [
                    'status'    => false,
                    'success'   => trans('bagisto_graphql::app.shop.response.not-found', ['name'    => 'Compare Product']),
                ];
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
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
        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        if (! bagisto_graphql()->guard($this->guard)->check() ) {
            throw new Exception(trans('bagisto_graphql::app.shop.customer.no-login-customer'));
        }

        try {
            $customer = bagisto_graphql()->guard($this->guard)->user();
            
            $compareProducts = $this->compareProductsRepository->findByField('customer_id', $customer->id);

            if ( $compareProducts->count() > 0 ) {
                foreach ($compareProducts as $compareProduct) {
                    $this->compareProductsRepository->delete($compareProduct->id);
                }
            }

            return [
                'status'    => true,
                'success'   => trans('velocity::app.customer.compare.removed-all'),
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}