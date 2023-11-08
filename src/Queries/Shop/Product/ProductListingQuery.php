<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Product;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\GraphQLAPI\Models\Catalog\Product;
use Webkul\Product\Repositories\ProductFlatRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Product\Helpers\Toolbar;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class ProductListingQuery extends BaseFilter
{

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Product\Repositories\ProductFlatRepository  $productFlatRepository
     * @param  \Webkul\Product\Repositories\ProductRepository  $productRepository
     * @param  \Webkul\Attribute\Repositories\AttributeRepository $attributeRepository
     * @return void
     */
    public function __construct(
        protected ProductFlatRepository $productFlatRepository,
        protected ProductRepository $productRepository,
        protected CategoryRepository $categoryRepository,
        protected AttributeRepository $attributeRepository,
        protected Toolbar $productHelperToolbar,
        protected CustomerRepository $customerRepository,

    ) {
    }

    /**
     * Retrive product from slug.
     *
     * @param  string  $slug
     * @param  string  $columns
     * @return \Webkul\Product\Contracts\Product
     */
    public function findBySlugOrFail($query, $input)
    {
        $slug = $input['slug'] ?? '';

        $product = app(ProductFlatRepository::class)->findOneWhere([
            'url_key' => $slug,
            'locale'  => app()->getLocale(),
            'channel' => core()->getCurrentChannelCode(),
        ]);

        if (! $product) {
            throw (new ModelNotFoundException)->setModel(
                get_class($this->model), $slug
            );
        }

        return $product;
    }

    /**
     * Get all products.
     *
     * @param  object  $query
     * @param  array  $input
     * @return \Illuminate\Http\Response
     */
    public function getAll($query, $input)
    {
        $params = array_merge([
            'status'               => 1,
            'visible_individually' => 1,
            'url_key'              => null,
        ], $input);

        if (! empty($params['search'])) {
                $params['name'] = $params['search'];
        }

        $product = app(ProductRepository::class)->scopeQuery(function ($query) use ($params) {
            $query = Product::with([
                'attribute_family',
                'images',
                'videos',
                'attribute_values',
                'price_indices',
                'inventory_indices',
                'reviews',
            ]); 

            $prefix = DB::getTablePrefix();
            $qb = $query
                    ->select('products.*')
                    ->leftJoin('products as variants', DB::raw('COALESCE(' . $prefix . 'variants.parent_id, ' . $prefix . 'variants.id)'), '=', 'products.id')
                    ->leftJoin('product_price_indices', function ($join) {
                        $customerGroup = $this->customerRepository->getCurrentGroup();

                        $join->on('products.id', '=', 'product_price_indices.product_id') 
                            ->where('product_price_indices.customer_group_id', $customerGroup->id);
            });

            if (! empty($params['category_id'])) {
                $qb->leftJoin('product_categories', 'product_categories.product_id', '=', 'products.id')
                    ->whereIn('product_categories.category_id', explode(',', $params['category_id']));
            }

            if (! empty($params['type'])) {
                $qb->where('products.type', $params['type']);
            }
        
            /**
             * Filter query by price.
             */
            if (! empty($params['price'])) {
                $priceRange = explode(',', $params['price']);

                $qb->whereBetween('product_price_indices.min_price', [
                    core()->convertToBasePrice(current($priceRange)),
                    core()->convertToBasePrice(end($priceRange)),
                ]);
            }

            /**
             * Retrieve all the filterable attributes.
             */
            $filterableAttributes = $this->attributeRepository->getProductDefaultAttributes(array_keys($params));

            /**
             * Filter the required attributes.
             */
            $attributes = $filterableAttributes->whereIn('code', [
                'name',
                'status',
                'visible_individually',
                'url_key',
            ]);


            /**
             * Filter collection by required attributes.
             */
            foreach ($attributes as $attribute) {
                $alias = $attribute->code . '_product_attribute_values';

                $qb->leftJoin('product_attribute_values as ' . $alias, 'products.id', '=', $alias . '.product_id')
                    ->where($alias . '.attribute_id', $attribute->id);

                if ($attribute->code == 'name') {
                    $qb->where($alias . '.text_value', 'like', '%' . urldecode($params['name']) . '%');
                } elseif ($attribute->code == 'url_key') {
                    if (empty($params['url_key'])) {
                        $qb->whereNotNull($alias . '.text_value');
                    } else {
                        $qb->where($alias . '.text_value', 'like', '%' . urldecode($params['url_key']) . '%');
                    }
                } else {
                    if (is_null($params[$attribute->code])) {
                        continue;
                    }

                    $qb->where($alias . '.' . $attribute->column_name, 1);
                }
            }

            /**
             * Filter the filterable attributes.
             */
            $attributes = $filterableAttributes->whereNotIn('code', [
                'price',
                'name',
                'status',
                'visible_individually',
                'url_key',
            ]);


            /**
             * Filter query by attributes.
             */
            if ($attributes->isNotEmpty()) {
                $qb->leftJoin('product_attribute_values', 'products.id', '=', 'product_attribute_values.product_id');

                $qb->where(function ($filterQuery) use ($params, $attributes) {
                    foreach ($attributes as $attribute) {
                        $filterQuery->orWhere(function ($attributeQuery) use ($params, $attribute) {
                            $attributeQuery = $attributeQuery->where('product_attribute_values.attribute_id', $attribute->id);

                            $values = explode(',', $params[$attribute->code]);

                            if ($attribute->type == 'price') {
                                $attributeQuery->whereBetween('product_attribute_values.' . $attribute->column_name, [
                                    core()->convertToBasePrice(current($values)),
                                    core()->convertToBasePrice(end($values)),
                                ]);
                            } else {
                                $attributeQuery->whereIn('product_attribute_values.' . $attribute->column_name, $values);
                            }
                        });
                    }
                });

                /**
                 * This is key! if a product has been filtered down to the same number of attributes that we filtered on,
                 * we know that it has matched all of the requested filters.
                 *
                 * To Do (@devansh): Need to monitor this.
                 */
                $qb->groupBy('products.id');
                $qb->havingRaw('COUNT(*) = ' . count($attributes));
            }
            /**
             * Sort collection.
             */
            $sortOptions = $this->productRepository->getSortOptions($params);
            
            if ($sortOptions['order'] != 'rand') {
                $attribute = $this->attributeRepository->findOneByField('code', $sortOptions['sort']);

                if ($attribute) {
                    if ($attribute->code === 'price') {  
                        $qb->orderBy('product_price_indices.min_price', $sortOptions['order']);
                    } else {
                        $alias = 'sort_product_attribute_values';

                        $qb->leftJoin('product_attribute_values as ' . $alias, function ($join) use ($alias, $attribute) {
                            $join->on('products.id', '=', $alias . '.product_id')
                                ->where($alias . '.attribute_id', $attribute->id)
                                ->where($alias . '.channel', core()->getRequestedChannelCode())
                                ->where($alias . '.locale', core()->getRequestedLocaleCode());
                        })
                            ->orderBy($alias . '.' . $attribute->column_name, $sortOptions['order']);
                    }
                } else {
                    /* `created_at` is not an attribute so it will be in else case */
                    $qb->orderBy('products.created_at', $sortOptions['order']);
                }
            } else {
                return $qb->inRandomOrder();
            }

            return $qb->groupBy('products.id');
        });

        /**
         * Apply scope query so we can fetch the raw sql and perform a count.
         */
        $count = collect(
            DB::select("select count(id) as aggregate from ({$product->select('products.id')->reorder('products.id')->toSql()}) c",
                $product->getBindings())
        )->pluck('aggregate')->first();

        $items = [];

        $limit = $this->productRepository->getPerPageLimit($params);

        $currentPage = Paginator::resolveCurrentPage('page');

        if ($count > 0) {
            $product->scopeQuery(function ($query) use ($currentPage, $limit) {
                return $query->forPage($currentPage, $limit);
            });

            $items = $product->get();
            // dd( $items ,"eftwert");

        }

        return new LengthAwarePaginator($items, $count, $limit, $currentPage, [
            'path'  => request()->url(),
            'query' => request()->query(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function getFilterAttributes($rootValue, array $args, GraphQLContext $context)
    {
        $category = $maxPrice = null;
        $filterAttributes = null;

        if (! empty($args['categorySlug'])) {
            $slugs = explode("/", $args['categorySlug']);
            $lastSlugs = end($slugs);
            
            $category = $this->categoryRepository->whereHas('translation', function ($q) use ($lastSlugs) {
                $q->where('slug', 'like', '%' . urldecode($lastSlugs) . '%');
            })->first();

            if ($category) {
                $maxPrice = $this->productRepository->getMaxPrice($category);

                if (empty($filterAttributes = $category->filterableAttributes)) {
                    $filterAttributes = $this->attributeRepository->getFilterAttributes();
                }
            }
        }

        $filterData = [];
        foreach ($filterAttributes as $key => $filterAttribute) {
            if ($filterAttribute->code != 'price') {
                $optionIds = $filterAttribute->options->pluck('id')->toArray();
                
                $filterData[$filterAttribute->code] = [
                    'key' => $filterAttribute->code,
                    'value'  => $optionIds,
                ];
            }
        }

        $availableSortOrders = [];
        foreach ($this->productHelperToolbar->getAvailableOrders() as $key => $label) {
            $keys = explode('-', $key);

            $availableSortOrders[$key] = [
                'key'   => $key,
                // 'label' => trans('shop::app.products.' . $label),
                'value' => [
                    'sort'  => current($keys),
                    'order' => end($keys),
                ]
            ];
        }
        
        return [
            'min_price'         => 0,
            'max_price'         => $maxPrice ?? 500,
            'filter_attributes' => $filterAttributes,
            'filter_data'       => $filterData,
            'sort_orders'       => $availableSortOrders,
        ];
    }
}
