<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Product;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Product\Models\ProductAttributeValueProxy;
use Webkul\Product\Repositories\ProductFlatRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Product\Helpers\Toolbar;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class ProductListingQuery extends BaseFilter
{
    /**
     * Product flat repository instance.
     *
     * @var \Webkul\Product\Repositories\ProductFlatRepository
     */
    protected $productFlatRepository;

    /**
     * Product repository instance.
     *
     * @var \Webkul\Product\Repositories\ProductRepository
     */
    protected $productRepository;

    /**
     * Category repository instance.
     *
     * @var \Webkul\Category\Repositories\CategoryRepository
     */
    protected $categoryRepository;

    /**
     * Attribute repository instance.
     *
     * @var \Webkul\Attribute\Repositories\AttributeRepository
     */
    protected $attributeRepository;

    /**
     * Toolbar helper instance.
     *
     * @var \Webkul\Product\Helpers\Toolbar
     */
    protected $productHelperToolbar;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Product\Repositories\ProductFlatRepository  $productFlatRepository
     * @param  \Webkul\Product\Repositories\ProductRepository  $productRepository
     * @param  \Webkul\Attribute\Repositories\AttributeRepository $attributeRepository
     * @return void
     */
    public function __construct(
        ProductFlatRepository $productFlatRepository,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        AttributeRepository $attributeRepository,
        Toolbar $productHelperToolbar
    ) {
        $this->productFlatRepository = $productFlatRepository;

        $this->productRepository = $productRepository;

        $this->categoryRepository = $categoryRepository;

        $this->attributeRepository = $attributeRepository;

        $this->productHelperToolbar = $productHelperToolbar;
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
        $params = $input;

        $qb = app(ProductRepository::class)->distinct()
            ->leftJoin('product_flat', 'products.id', '=', 'product_flat.product_id')
            ->addSelect('products.*')
            ->join('product_flat as variants', 'product_flat.id', '=', DB::raw('COALESCE(' . DB::getTablePrefix() . 'variants.parent_id, ' . DB::getTablePrefix() . 'variants.id)'))
            ->leftJoin('product_categories', 'product_categories.product_id', '=', 'product_flat.product_id')
            ->leftJoin('product_attribute_values', 'product_attribute_values.product_id', '=', 'variants.product_id')
            ->whereIn('products.type', ['simple', 'configurable', 'virtual'])
            ->where('product_flat.channel', core()->getRequestedChannelCode())
            ->where('product_flat.locale', core()->getRequestedLocaleCode())
            ->whereNotNull('product_flat.url_key');
            
        if (! empty($params['category_slug'])) {
            
            $categoryId = $this->categoryRepository->whereHas('translation', function ($q) use ($params) {
                $q->where('slug', 'like', '%' . urldecode($params['category_slug']) . '%');
            })->pluck('id')->first();

            if ($categoryId) {
                $qb->where('product_categories.category_id', $categoryId);
            }
        }

        if (! core()->getConfigData('catalog.products.homepage.out_of_stock_items')) {
            $qb = $this->productRepository->checkOutOfStockItem($qb);
        }

        if (! empty($params['status'])) {
            $qb->where('product_flat.status', 1);
        }

        if (! empty($params['visible_individually'])) {
            $qb->where('product_flat.visible_individually', 1);
        }

        if (! empty($params['new'])) {
            $qb->where('product_flat.new', $params['new']);
        }

        if (! empty($params['featured'])) {
            $qb->where('product_flat.featured', $params['featured']);
        }

        if (! empty($params['search'])) {
            $qb->where('product_flat.name', 'like', '%' . urldecode($params['search']) . '%');
        }

        /* added for api as per the documentation */
        if (! empty($params['name'])) {
            $qb->where('product_flat.name', 'like', '%' . urldecode($params['name']) . '%');
        }

        /* added for api as per the documentation */
        if (! empty($params['url_key'])) {
            $qb->where('product_flat.url_key', 'like', '%' . urldecode($params['url_key']) . '%');
        }

        # sort direction
        $orderDirection = 'asc';
        if (isset($params['order']) && in_array($params['order'], ['desc', 'asc'])) {
            $orderDirection = $params['order'];
        } else {
            $sortOptions = $this->getDefaultSortByOption();
            $orderDirection = ! empty($sortOptions) ? $sortOptions[1] : 'asc';
        }

        if (isset($params['sort'])) {
            $this->checkSortAttributeAndGenerateQuery($qb, $params['sort'], $orderDirection);
        } else {
            $sortOptions = $this->getDefaultSortByOption();
            if (! empty($sortOptions)) {
                $this->checkSortAttributeAndGenerateQuery($qb, $sortOptions[0], $orderDirection);
            }
        }

        if (! empty($params['price'])) {
            $priceFilter = $params['price'];
            $priceRange = explode(',', $priceFilter);

            if (count($priceRange) > 0) {
                $customerGroupId = null;

                $customerGuestGroup = app('Webkul\Customer\Repositories\CustomerGroupRepository')->getCustomerGuestGroup();

                if ($customerGuestGroup) {
                    $customerGroupId = $customerGuestGroup->id;
                }

                $qb
                    ->leftJoin('catalog_rule_product_prices', 'catalog_rule_product_prices.product_id', '=', 'variants.product_id')
                    ->leftJoin('product_customer_group_prices', 'product_customer_group_prices.product_id', '=', 'variants.product_id')
                    ->where(function ($qb) use ($priceRange, $customerGroupId) {
                        $qb->where(function ($qb) use ($priceRange) {
                            $qb
                                ->where('variants.min_price', '>=', core()->convertToBasePrice($priceRange[0]))
                                ->where('variants.min_price', '<=', core()->convertToBasePrice(end($priceRange)));
                        })
                            ->orWhere(function ($qb) use ($priceRange) {
                                $qb
                                    ->where('catalog_rule_product_prices.price', '>=', core()->convertToBasePrice($priceRange[0]))
                                    ->where('catalog_rule_product_prices.price', '<=', core()->convertToBasePrice(end($priceRange)));
                            })
                            ->orWhere(function ($qb) use ($priceRange, $customerGroupId) {
                                $qb
                                    ->where('product_customer_group_prices.value', '>=', core()->convertToBasePrice($priceRange[0]))
                                    ->where('product_customer_group_prices.value', '<=', core()->convertToBasePrice(end($priceRange)))
                                    ->where('product_customer_group_prices.customer_group_id', '=', $customerGroupId);
                            });
                    });
            }
        }

        $attributeFilterParams = $params;

        if (isset($params['price'])) {
            unset($attributeFilterParams['price']);
        };

        if (! empty($params['filters'])) {
            foreach ($params['filters'] as $attribute) {
                
                if (
                    ! isset($attribute['key']) 
                    || ! isset($attribute['value'])
                ) {
                    continue;
                }

                $attributeFilterParams[$attribute['key']] = is_array($attribute['value']) ? implode(",", $attribute['value']) : $attribute['value'];
            }

            unset($attributeFilterParams['filters']);
        };

        $attributeFilters = $this->attributeRepository
            ->getProductDefaultAttributes(array_keys($attributeFilterParams));

        if (count($attributeFilters) > 0) {
            $qb->where(function ($filterQuery) use ($attributeFilters, $attributeFilterParams) {

                foreach ($attributeFilters as $attribute) {
                    $filterQuery->orWhere(function ($attributeQuery) use ($attribute, $attributeFilterParams) {
                        $column = DB::getTablePrefix() . 'product_attribute_values.' . ProductAttributeValueProxy::modelClass()::$attributeTypeFields[$attribute->type];

                        $filterInputValues = explode(',', $attributeFilterParams[$attribute->code]);

                        # define the attribute we are filtering
                        $attributeQuery = $attributeQuery->where('product_attribute_values.attribute_id', $attribute->id);

                        # apply the filter values to the correct column for this type of attribute.
                        if ($attribute->type != 'price') {

                            $attributeQuery->where(function ($attributeValueQuery) use ($column, $filterInputValues) {
                                foreach ($filterInputValues as $filterValue) {
                                    if (! is_numeric($filterValue)) {
                                        continue;
                                    }
                                    $attributeValueQuery->orWhereRaw("find_in_set(?, {$column})", [$filterValue]);
                                }
                            });
                        } else {
                            $attributeQuery->where($column, '>=', core()->convertToBasePrice(current($filterInputValues)))
                                ->where($column, '<=', core()->convertToBasePrice(end($filterInputValues)));
                        }
                    });
                }
            });

            # this is key! if a product has been filtered down to the same number of attributes that we filtered on,
            # we know that it has matched all of the requested filters.
            $qb->groupBy('variants.id');
            $qb->havingRaw('COUNT(*) = ' . count($attributeFilters));
        }

        return $qb->groupBy('product_flat.id');
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
                $maxPrice = $this->productFlatRepository->handleCategoryProductMaximumPrice($category);

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
                'label' => $label,
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

    /**
     * Get default sort by option.
     *
     * @return array
     */
    private function getDefaultSortByOption()
    {
        $value = core()->getConfigData('catalog.products.storefront.sort_by');

        $config = $value ? $value : 'name-desc';

        return explode('-', $config);
    }

    /**
     * Check sort attribute and generate query.
     *
     * @param  object  $query
     * @param  string  $sort
     * @param  string  $direction
     * @return object
     */
    private function checkSortAttributeAndGenerateQuery($query, $sort, $direction)
    {
        $attribute = $this->attributeRepository->findOneByField('code', $sort);

        if ($attribute) {
            if ($attribute->code === 'price') {
                $query->orderBy('product_flat.min_price', $direction);
            } else {
                $query->orderBy('product_flat.' . $attribute->code, $direction);
            }
        } else {
            /* `created_at` is not an attribute so it will be in else case */
            $query->orderBy('product_flat.created_at', $direction);
        }

        return $query;
    }
}
