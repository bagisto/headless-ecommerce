<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\GraphQLAPI\Queries\BaseFilter;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Marketing\Repositories\SearchSynonymRepository;
use Webkul\Product\Helpers\Toolbar;
use Webkul\Product\Repositories\ElasticSearchRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Theme\Repositories\ThemeCustomizationRepository;

class HomePageQuery extends BaseFilter
{
    /**
     * Using const variable for status
     */
    const STATUS = 1;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected AttributeRepository $attributeRepository,
        protected ProductRepository $productRepository,
        protected ElasticSearchRepository $elasticSearchRepository,
        protected CategoryRepository $categoryRepository,
        protected CustomerRepository $customerRepository,
        protected SearchSynonymRepository $searchSynonymRepository,
        protected ThemeCustomizationRepository $themeCustomizationRepository,
        protected Toolbar $productHelperToolbar
    ) {}

    /**
     * Get the default channel.
     *
     * @return \Webkul\Core\Contracts\Channel
     */
    public function getDefaultChannel()
    {
        return core()->getDefaultChannel();
    }

    /**
     * Get the theme customization data.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getThemeCustomizationData()
    {
        visitor()->visit();

        $customizations = $this->themeCustomizationRepository->orderBy('sort_order')->findWhere([
            'status'     => self::STATUS,
            'channel_id' => core()->getCurrentChannel()->id,
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

            if (
                $item->type == 'product_carousel'
                || $item->type == 'category_carousel'
            ) {
                if (isset($item->options['title'])) {
                    $options['title'] = $item->options['title'];
                }

                $options['filters'] = [];

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
     *
     * @return mixed
     *
     * @throws CustomException
     */
    public function getCategories(mixed $rootValue, array $args)
    {
        if (! empty($args['get_category_tree'])) {
            return $this->categoryRepository->getVisibleCategoryTree(core()->getCurrentChannel()->root_category_id);
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

            return $this->categoryRepository->getAll($params);
        }

        throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
    }

    /**
     * Get all products.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllProducts(mixed $rootValue, array $input)
    {
        $searchEngine = core()->getConfigData('catalog.products.search.engine') === 'elastic'
            ? core()->getConfigData('catalog.products.search.storefront_mode')
            : 'database';

        $params = array_merge($input, [
            'channel_id'           => core()->getCurrentChannel()->id,
            'status'               => 1,
            'visible_individually' => 1,
        ]);

        $products = $searchEngine === 'elastic'
            ? $this->searchFromElastic($params)
            : $this->searchFromDatabase($params);

        return [
            'paginator_info' => bagisto_graphql()->getPaginatorInfo($products),
            'data'           => $products->getCollection(),
        ];
    }

    /**
     * Search product from database.
     *
     * @return \Illuminate\Support\Collection
     */
    public function searchFromDatabase(array $params = [])
    {
        $params['url_key'] ??= null;

        $prefix = DB::getTablePrefix();

        $qb = $this->productRepository->distinct()
            ->select('products.*')
            ->leftJoin('products as variants', DB::raw('COALESCE('.$prefix.'variants.parent_id, '.$prefix.'variants.id)'), '=', 'products.id')
            ->leftJoin('product_price_indices', function ($join) {
                $customerGroup = $this->customerRepository->getCurrentGroup();

                $join->on('products.id', '=', 'product_price_indices.product_id')
                    ->where('product_price_indices.customer_group_id', $customerGroup->id);
            });

        /**
         * Handle category_id filtering.
         */
        if (! empty($params['category_id'])) {
            $qb->leftJoin('product_categories', 'product_categories.product_id', '=', 'products.id')
                ->whereIn('product_categories.category_id', explode(',', $params['category_id']));
        }

        if (! empty($params['channel_id'])) {
            $qb->leftJoin('product_channels', 'products.id', '=', 'product_channels.product_id')
                ->where('product_channels.channel_id', explode(',', $params['channel_id']));
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
            $alias = $attribute->code.'_product_attribute_values';

            $qb->leftJoin('product_attribute_values as '.$alias, 'products.id', '=', $alias.'.product_id')
                ->where($alias.'.attribute_id', $attribute->id);

            if ($attribute->code == 'name') {
                $synonyms = $this->searchSynonymRepository->getSynonymsByQuery(urldecode($params['name']));

                $qb->where(function ($subQuery) use ($alias, $synonyms) {
                    foreach ($synonyms as $synonym) {
                        $subQuery->orWhere($alias.'.text_value', 'like', '%'.$synonym.'%');
                    }
                });
            } elseif ($attribute->code == 'url_key') {
                if (empty($params['url_key'])) {
                    $qb->whereNotNull($alias.'.text_value');
                } else {
                    $qb->where($alias.'.text_value', 'like', '%'.urldecode($params['url_key']).'%');
                }
            } else {
                if (is_null($params[$attribute->code])) {
                    continue;
                }

                $qb->where($alias.'.'.$attribute->column_name, 1);
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
            $qb->where(function ($filterQuery) use ($qb, $params, $attributes) {
                $aliases = [
                    'products' => 'product_attribute_values',
                    'variants' => 'variant_attribute_values',
                ];

                foreach ($aliases as $table => $tableAlias) {
                    $filterQuery->orWhere(function ($subFilterQuery) use ($qb, $params, $attributes, $table, $tableAlias) {
                        foreach ($attributes as $attribute) {
                            $alias = $attribute->code.'_'.$tableAlias;

                            $qb->leftJoin('product_attribute_values as '.$alias, function ($join) use ($table, $alias, $attribute) {
                                $join->on($table.'.id', '=', $alias.'.product_id');

                                $join->where($alias.'.attribute_id', $attribute->id);
                            });

                            $subFilterQuery->whereIn($alias.'.'.$attribute->column_name, explode(',', $params[$attribute->code]));
                        }
                    });
                }
            });

            $qb->groupBy('products.id');
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

                    $qb->leftJoin('product_attribute_values as '.$alias, function ($join) use ($alias, $attribute) {
                        $join->on('products.id', '=', $alias.'.product_id')
                            ->where($alias.'.attribute_id', $attribute->id);

                        if ($attribute->value_per_channel) {
                            if ($attribute->value_per_locale) {
                                $join->where($alias.'.channel', core()->getRequestedChannelCode())
                                    ->where($alias.'.locale', core()->getRequestedLocaleCode());
                            } else {
                                $join->where($alias.'.channel', core()->getRequestedChannelCode());
                            }
                        } else {
                            if ($attribute->value_per_locale) {
                                $join->where($alias.'.locale', core()->getRequestedLocaleCode());
                            }
                        }
                    })
                        ->orderBy($alias.'.'.$attribute->column_name, $sortOptions['order']);
                }
            } else {
                /* `created_at` is not an attribute so it will be in else case */
                $qb->orderBy('products.created_at', $sortOptions['order']);
            }
        } else {
            return $qb->inRandomOrder();
        }

        $qb = $qb->groupBy('products.id');

        $limit = $this->getPerPageLimit($params);

        return $qb->paginate($limit, ['*'], 'page', $params['page'] ?? 1);
    }

    /**
     * Search product from elastic search.
     *
     * @return \Illuminate\Support\Collection
     */
    public function searchFromElastic(array $params = [])
    {
        $currentPage = $params['page'] ?? 1;

        $limit = $this->getPerPageLimit($params);

        $sortOptions = $this->getSortOptions($params);

        $indices = $this->elasticSearchRepository->search($params, [
            'from'  => ($currentPage * $limit) - $limit,
            'limit' => $limit,
            'sort'  => $sortOptions['sort'],
            'order' => $sortOptions['order'],
        ]);

        $query = $this->productRepository
            ->whereIn('id', $indices['ids'])
            ->orderBy(DB::raw('FIELD(id, '.implode(',', $indices['ids']).')'));

        return new LengthAwarePaginator(
            $indices['total'] ? $query->get() : [],
            $indices['total'],
            $limit,
            $currentPage
        );
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

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function getFilterAttributes(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $slug = $args['category_slug'];

        $filterData = [];

        $availableSortOrders = [];

        $category = $this->categoryRepository->whereHas('translation', function ($q) use ($slug) {
            $q->where('slug', urldecode($slug));
        })->first();

        if (empty($filterableAttributes = $category?->filterableAttributes)) {
            $filterableAttributes = $this->attributeRepository->getFilterableAttributes();
        }

        $maxPrice = $this->productRepository->getMaxPrice(['category_id' => $category?->id]);

        foreach ($filterableAttributes as $key => $filterAttribute) {
            if ($filterAttribute->code == 'price') {
                continue;
            }

            $optionIds = $filterAttribute->options->pluck('id')->toArray();

            $filterData[$filterAttribute->code] = [
                'key'    => $filterAttribute->code,
                'value'  => $optionIds,
            ];
        }

        foreach ($this->productHelperToolbar->getAvailableOrders() as $key => $label) {
            $availableSortOrders[$key] = [
                'key'      => $key,
                'title'    => $label['title'],
                'value'    => $label['value'],
                'sort'     => $label['sort'],
                'order'    => $label['order'],
                'position' => $label['position'],
            ];
        }

        return [
            'min_price'         => 0,
            'max_price'         => $maxPrice,
            'filter_attributes' => $filterableAttributes,
            'filter_data'       => $filterData,
            'sort_orders'       => $availableSortOrders,
        ];
    }
}
