<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Illuminate\Support\Facades\DB;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Product\Repositories\ProductFlatRepository;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Customer\Repositories\WishlistRepository;
use Webkul\Shop\Repositories\ThemeCustomizationRepository;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class HomePageQuery extends BaseFilter
{
    /**
     * Using const variable for status
     */
    const STATUS = 1;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Product\Repositories\AttributeRepository  $attributeRepository
     * @param  \Webkul\Product\Repositories\ProductRepository  $productRepository
     * @param  \Webkul\Product\Repositories\ProductFlatRepository  $productFlatRepository
     * @param  \Webkul\Category\Repositories\CategoryRepository $categoryRepository
     * @param  \Webkul\Customer\Repositories\CustomerRepository $customerRepository
     * @param  \Webkul\Customer\Repositories\WishlistRepository $wishlistRepository
     * @param  \Webkul\Velocity\Repositories\VelocityMetadataRepository $velocityMetadataRepository
    * @return void
     */
    public function __construct(
        protected AttributeRepository $attributeRepository,
        protected ProductRepository $productRepository,
        protected ProductFlatRepository $productFlatRepository,
        protected CategoryRepository $categoryRepository,
        protected CustomerRepository $customerRepository,
        protected WishlistRepository $wishlistRepository,
        protected ThemeCustomizationRepository $themeCustomizationRepository,
    )
    {
    }

    /**
     * @param mixed $rootValue
     * @param array $args
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext $context
     * @return \Webkul\Core\Contracts\Channel
     */
    public function getDefaultChannel($rootValue, array $args, GraphQLContext $context)
    {
        return core()->getDefaultChannel();
    }

    /**
     *@param mixed $rootValue
     * @param array $args
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext $context
     * @return mixed
     */
    public function getThemeCustomizationData($rootValue, array $args, GraphQLContext $context)
    {
        visitor()->visit();

        $customizations = $this->themeCustomizationRepository->orderBy('sort_order')->findWhere([
            'status'     => self::STATUS,
            'channel_id' => core()->getCurrentChannel()->id
        ]);

        $result = $customizations->map(function ($item) {

            if ($item->type == 'image_carousel') {

                $images['images'] = [];

                foreach ($item->options['images'] as $i => $element) {
                    $images['images'][$i] = array_merge($element, ['image_url' => asset('/').$element['image']]);
                }

                $item->options = $images;
            }

            if ($item->type == 'static_content') {

                $staticContent['css'] = $item->options['css'];
                $staticContent['html'] = [];

                $staticContent['html'] = str_replace('src="" data-src="storage', 'src="'.asset('/storage'), $item->options['html']);

                $item->options = $staticContent;
            }

            if ($item->type == 'product_carousel' || $item->type == 'category_carousel') {

                if (isset($item->options['title'])) {
                    $options['title'] =  $item->options['title'];
                }

                $options['filters'] =  [];

                $i = 0;

                foreach ($item->options['filters'] as $key => $value) {
                    $options['filters'][$i]['key'] = $key;
                    $options['filters'][$i]['value'] = $value;

                    $i++;
                }

                $item->options = $options;
            }

            return $item;
        });

        return $result;
    }

    /**
     * Get all categories in tree format.
     * And 
     * @param mixed $rootValue
     * @param array $args
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext $context
     */
    public function getCategories($rootValue, array $args, GraphQLContext $context)
    {
        if (! empty($args['id'])) {
            $categories = $this->categoryRepository->getVisibleCategoryTree($args['id']);
        }

        if (! empty($args['input'])) {
            $filters = array_filter($args['input']);
            $params = [];

            foreach ($filters as $input) {
                $params[$input['key']] = $input['value'];
            }

            /**
             * These are the default parameters. By default, only the enabled category
             * will be shown in the current locale.
             */
            if (! isset($params['status'])) {
                $params = array_merge(['status' => 1], $params);
            }

            if (! isset($params['locale'])) {
                $params = array_merge(['locale' => app()->getLocale()], $params);
            }

            $categories = $this->categoryRepository->getAll($params);
        }

        return $categories;
    }

    /**
     * Get all products.
     * @param mixed $rootValue
     * @param array $args
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext $context
     * @return \Illuminate\Support\Collection
     */
    public function getAllProducts($query, $input)
    {
        return $this->searchFromDatabase($query, $input);
    }

    /**
     * Search product from database.
     *
     *
     * @return \Illuminate\Support\Collection
     */
    public function searchFromDatabase($query, $input)
    {
        $params = [
            'status'               => 1,
            'visible_individually' => 1,
            'url_key'              => null,
        ];

        $filters = array_filter($input);

        foreach ($filters as $input) {
            $params[$input['key']] = $input['value'];
        }

        if (! empty($params['search'])) {
            $params['name'] = $params['search'];
        }

        $prefix = DB::getTablePrefix();

        $qb = app(ProductRepository::class)->distinct()
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
        $sortOptions = $this->getSortOptions($params);

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
    }

    /**
     * Fetch per page limit from toolbar helper. Adapter for this repository.
     */
    public function getPerPageLimit(array $params): int
    {
        return product_toolbar()->getLimit($params);
    }

    /**
     * Fetch sort option from toolbar helper. Adapter for this repository.
     */
    public function getSortOptions(array $params): array
    {
        return product_toolbar()->getOrder($params);
    }
}
