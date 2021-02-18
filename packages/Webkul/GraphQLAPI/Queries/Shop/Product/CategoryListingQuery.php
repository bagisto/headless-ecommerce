<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Product;

use Webkul\Product\Repositories\ProductFlatRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Product\Models\ProductAttributeValueProxy;
use Webkul\Attribute\Repositories\AttributeRepository;
use DB;

class CategoryListingQuery
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
     * @param  \Webkul\Category\Repositories\CategoryRepository $categoryRepository
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
    public function getListingProduct($query, $input)
    {
        $params = $input;

        $categoryId = $this->categoryRepository->whereHas('translation', function ($q) use ($input) {
            $q->where('name', $input['categoryname']);
        })->pluck("id")->first();

        if (!isset($categoryId)) {
            return [];
        }

        # sort direction
        $orderDirection = 'asc';
        if (isset($params['order']) && in_array($params['order'], ['desc', 'asc'])) {
            $orderDirection = $params['order'];
        } else {
            $sortOptions = $this->getDefaultSortByOption();
            $orderDirection = !empty($sortOptions) ? $sortOptions[1] : 'asc';
        }

        $channel = core()->getCurrentChannelCode();

        $locale = app()->getLocale();

        $data = $query->where('product_flat.channel', $channel)
                ->distinct()
                ->select('product_flat.*')
                ->join('product_flat as variants', 'product_flat.id', '=', DB::raw('COALESCE(' . DB::getTablePrefix() . 'variants.parent_id, ' . DB::getTablePrefix() . 'variants.id)'))
                ->leftJoin('product_attribute_values', 'product_attribute_values.product_id', '=', 'variants.product_id')
                ->where('product_flat.locale', $locale)
                ->whereNotNull('product_flat.url_key')
                ->whereHas('product.categories', function ($q) use ($categoryId) {
                    $q->where('category_id', $categoryId);
                });

        if (isset($params['sort'])) {
            $data->orderBy($params['sort'], $orderDirection);
        } else {
            $sortOptions = $this->getDefaultSortByOption();
            if (!empty($sortOptions)) {
                $this->checkSortAttributeAndGenerateQuery($data, $sortOptions[0], $orderDirection);
            }
        }

        if (isset($params['price']) && $priceFilter = $params['price']) {

            $priceRange = explode(',', $priceFilter);

            if (count($priceRange) > 0) {
                $data->where('variants.min_price', '>=', core()->convertToBasePrice($priceRange[0]));
                $data->where('variants.min_price', '<=', core()->convertToBasePrice(end($priceRange)));
            }
        }

        unset($params['price']);

        $attributeFilters = $this->attributeRepository->getProductDefaultAttributes(array_keys($params));

        if (count($attributeFilters) > 0) {
            $data->where(function ($filterQuery) use ($attributeFilters, $params) {
                foreach ($attributeFilters as $attribute) {
                    $filterQuery->orWhere(function ($attributeQuery) use ($attribute, $params) {

                        $column = DB::getTablePrefix() . 'product_attribute_values.' . ProductAttributeValueProxy::modelClass()::$attributeTypeFields[$attribute->type];

                        $filterInputValues = explode(',', $params[$attribute->code]);

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

            $data->groupBy('variants.id');
            $data->havingRaw('COUNT(*) = ' . count($attributeFilters));
        }       
       
        $data->groupBy('product_flat.id');
    
        return $data;
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
                $query->orderBy('min_price', $direction);
            } else {
                $query->orderBy($sort === 'created_at' ? 'created_at' : $attribute->code, $direction);
            }
        }

        return $query;
    }
}
