<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use PhpOffice\PhpSpreadsheet\Calculation\Engineering\Compare;
use Webkul\Customer\Repositories\CompareItemRepository;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Product\Repositories\ProductFlatRepository;
use Webkul\Product\Repositories\ProductRepository;

class CompareMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CompareItemRepository $compareItemRepository,
        protected ProductRepository $productRepository,
        protected ProductFlatRepository $productFlatRepository
    ) {
        Auth::setDefaultDriver('api');

        $this->middleware('auth:api');
    }

    /**
     * Returns customer's compare product list
     *
     * @return \Illuminate\Http\Response
     */
    public function compareProducts($rootValue, array $args, GraphQLContext $context)
    {
        if (! auth()->check()) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.no-login-customer'));
        }

        try {
            $params = $args['input'] ?? ($args['id'] ?? []);

            $currentPage = $params['page'] ?? 1;

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });

            $compareProducts = app(CompareItemRepository::class)
                ->getModel()
                ->with('product')
                ->withWhereHas('customer', function ($query) {
                    $query->where('id', auth()->user()->id);
                })
                ->when(! empty($args['id']), function ($query) use ($args) {
                    return $query->where('id', $args['id']);
                });

            if ($compareProducts->count()) {
                if (empty($args['id'])) {
                    return $compareProducts->paginate($params['limit'] ?? 10);
                } else {
                    return $compareProducts->first();
                }
            }

            throw new CustomException('You have no items in your compare list');
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
        if (empty($args['input'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        if (! auth()->check()) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.no-login-customer'));
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        try {
            $compareProduct = $this->compareItemRepository->findOneByField([
                'customer_id' => auth()->user()->id,
                'product_id'  => $data['product_id'],
            ]);

            if ($compareProduct) {
                return [
                    'success'        => trans('shop::app.compare.already-added'),
                    'compareProduct' => [$compareProduct],
                ];
            } else {
                $this->compareItemRepository->create([
                    'customer_id' => auth()->user()->id,
                    'product_id'  => $data['product_id'],
                ]);

                return [
                    'success'        => trans('shop::app.compare.item-add-success'),
                    'compareProduct' => $this->compareItemRepository->findWhere([
                        'customer_id' => auth()->user()->id,
                    ]),
                ];
            }
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
        if (empty($args['input'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        if (! auth()->check()) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.no-login-customer'));
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        try {
            $compareProduct = $this->compareItemRepository->findOneWhere($data);

            if ($compareProduct) {
                $this->compareItemRepository->delete($compareProduct->id);

                return [
                    'status'         => true,
                    'success'        => trans('shop::app.compare.remove-success'),
                    'compareProduct' => $this->compareItemRepository->findWhere([
                        'customer_id' => auth()->user()->id,
                    ]),
                ];
            } else {
                return [
                    'status'  => false,
                    'success' => trans('bagisto_graphql::app.shop.customer.account.not-found', ['name' => 'Compare Product']),
                ];
            }
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Remove all the compare entries of customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll($rootValue, array $args, GraphQLContext $context)
    {
        if (! auth()->check()) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.no-login-customer'));
        }

        try {
            $this->compareItemRepository->deleteWhere([
                'customer_id' => auth()->user()->id,
            ]);

            return [
                'status'  => true,
                'success' => trans('shop::app.compare.remove-all-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
