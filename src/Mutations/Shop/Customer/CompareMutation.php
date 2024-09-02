<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Customer\Repositories\CompareItemRepository;
use Webkul\GraphQLAPI\Validators\CustomException;

class CompareMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected CompareItemRepository $compareItemRepository)
    {
        Auth::setDefaultDriver('api');
    }

    /**
     * Returns customer's compare product list
     *
     * @return array
     *
     * @throws CustomException
     */
    public function compareProducts(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $customer = bagisto_graphql()->authorize();

        try {
            $currentPage = $args['page'] ?? 1;

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

        try {
            $compareProduct = $this->compareItemRepository->findOneByField([
                'customer_id' => auth()->user()->id,
                'product_id'  => $args['product_id'],
            ]);

            if ($compareProduct) {
                return [
                    'success'        => true,
                    'message'        => trans('shop::app.compare.already-added'),
                    'compareProduct' => [$compareProduct],
                ];
            } else {
                $this->compareItemRepository->create([
                    'customer_id' => auth()->user()->id,
                    'product_id'  => $args['product_id'],
                ]);

                return [
                    'success'        => true,
                    'message'        => trans('shop::app.compare.item-add-success'),
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

        try {
            $compareProduct = $this->compareItemRepository->findOneWhere([
                'customer_id' => auth()->user()->id,
                'product_id'  => $args['product_id'],
            ]);

            if ($compareProduct) {
                $this->compareItemRepository->delete($compareProduct->id);

                return [
                    'success'        => true,
                    'message'        => trans('shop::app.compare.remove-success'),
                    'compareProduct' => $this->compareItemRepository->findWhere([
                        'customer_id' => auth()->user()->id,
                    ]),
                ];
            } else {
                return [
                    'success' => false,
                    'message' => trans('bagisto_graphql::app.shop.customer.account.not-found', ['name' => 'Compare Product']),
                ];
            }
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
            $this->compareItemRepository->deleteWhere([
                'customer_id' => auth()->user()->id,
            ]);

            return [
                'success' => true,
                'message' => trans('shop::app.compare.remove-all-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
