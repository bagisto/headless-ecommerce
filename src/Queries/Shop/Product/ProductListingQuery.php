<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Product;

use Webkul\GraphQLAPI\Queries\BaseFilter;
use Webkul\Product\Repositories\ProductFlatRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Product\Models\ProductAttributeValueProxy;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Category\Repositories\CategoryRepository;
use Illuminate\Support\Facades\DB;

class ProductListingQuery extends BaseFilter
{
    /**
     * ProductFlatRepository object
     *
     * @var \Webkul\Product\Repositories\ProductFlatRepository
     */
    protected $productFlatRepository;

    /**
     * ProductRepository object
     *
     * @var \Webkul\Product\Repositories\ProductRepository
     */
    protected $productRepository;

    /**
     * CategoryRepository object
     *
     * @var \Webkul\Category\Repositories\CategoryRepository
     */
    protected $categoryRepository;

    /**
     * AttributeRepository object
     *
     * @var \Webkul\Attribute\Repositories\AttributeRepository
     */
    protected $attributeRepository;

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
        AttributeRepository $attributeRepository
    ) {
        $this->productFlatRepository = $productFlatRepository;

        $this->productRepository = $productRepository;

        $this->categoryRepository = $categoryRepository;

        $this->attributeRepository = $attributeRepository;
    }
    
    /**
     * filter the data .
     *
     * @param  object  $query
     * @param  array $input
     * @return \Illuminate\Http\Response
     */
    public function getAll($query, $input)
    {
        $params = $input;

        $channel = core()->getRequestedChannelCode();

        $locale = core()->getRequestedLocaleCode();
        
        $qb = $query->distinct()
            ->select('products.*')
            ->leftJoin('product_flat as pf', 'pf.product_id', '=', 'products.id')
            ->join('product_flat as variants', 'pf.id', '=', DB::raw('COALESCE(' . DB::getTablePrefix() . 'variants.parent_id, ' . DB::getTablePrefix() . 'variants.id)'))
            ->leftJoin('product_categories', 'product_categories.product_id', '=', 'pf.product_id')
            ->leftJoin('product_attribute_values', 'product_attribute_values.product_id', '=', 'variants.product_id')
            ->whereIn('products.type', ['simple'])
            ->where('pf.channel', $channel)
            ->where('pf.locale', $locale)
            ->whereNotNull('pf.url_key');

        if (isset($params['categorySlug']) && $params['categorySlug']) {
            $categoryId = $this->categoryRepository->whereHas('translation', function ($q) use ($params) {
                $q->where('slug', 'like', '%' . urldecode($params['categorySlug']) . '%');
            })->pluck('id')->first();
            
            if ($categoryId) {
                $qb->where('product_categories.category_id', $categoryId);
            }
        }

        if (! core()->getConfigData('catalog.products.homepage.out_of_stock_items')) {
            $qb = $this->productRepository->checkOutOfStockItem($qb);
        }

        if (is_null(request()->input('status'))) {
            $qb->where('pf.status', 1);
        }

        if (is_null(request()->input('visible_individually'))) {
            $qb->where('pf.visible_individually', 1);
        }

        if (isset($params['search']) && $params['search']) {
            $qb->where('pf.name', 'like', '%' . urldecode($params['search']) . '%');
        }

        /* added for api as per the documentation */
        if (isset($params['name']) && $params['name']) {
            $qb->where('pf.name', 'like', '%' . urldecode($params['name']) . '%');
        }

        /* added for api as per the documentation */
        if (isset($params['url_key']) && $params['url_key']) {
            $qb->where('pf.url_key', 'like', '%' . urldecode($params['url_key']) . '%');
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

        if (isset($params['price']) && $params['price']) {
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
                        $qb->where(function ($qb) use ($priceRange){
                            $qb
                                ->where('variants.min_price', '>=',  core()->convertToBasePrice($priceRange[0]))
                                ->where('variants.min_price', '<=',  core()->convertToBasePrice(end($priceRange)));
                        })
                        ->orWhere(function ($qb) use ($priceRange) {
                            $qb
                                ->where('catalog_rule_product_prices.price', '>=',  core()->convertToBasePrice($priceRange[0]))
                                ->where('catalog_rule_product_prices.price', '<=',  core()->convertToBasePrice(end($priceRange)));
                        })
                        ->orWhere(function ($qb) use ($priceRange, $customerGroupId) {
                            $qb
                                ->where('product_customer_group_prices.value', '>=',  core()->convertToBasePrice($priceRange[0]))
                                ->where('product_customer_group_prices.value', '<=',  core()->convertToBasePrice(end($priceRange)))
                                ->where('product_customer_group_prices.customer_group_id', '=', $customerGroupId);
                        });
                    });
            }
        }

        $attributeFilterParams = $params;
        if ( isset($params['price'])) {
            unset($attributeFilterParams['price']);
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

        return $qb->groupBy('pf.id');
    }

    /**
     * Get default sort by option
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
     * Check sort attribute and generate query
     *
     * @param object $query
     * @param string $sort
     * @param string $direction
     *
     * @return object
     */
    private function checkSortAttributeAndGenerateQuery($query, $sort, $direction)
    {
        $attribute = $this->attributeRepository->findOneByField('code', $sort);

        if ($attribute) {
            if ($attribute->code === 'price') {
                $query->orderBy('pf.min_price', $direction);
            } else {
                $query->orderBy('pf.' . $attribute->code, $direction);
            }
        } else {
            /* `created_at` is not an attribute so it will be in else case */
            $query->orderBy('pf.created_at', $direction);
        }

        return $query;
    }
}
