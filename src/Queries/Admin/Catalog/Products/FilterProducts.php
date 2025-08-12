<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Catalog\Products;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Webkul\Core\Facades\ElasticSearch;
use Webkul\GraphQLAPI\Queries\BaseFilter;
use Webkul\Product\Repositories\ProductRepository;

class FilterProducts extends BaseFilter
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected ProductRepository $productRepository) {}

    /**
     * filter the product's query
     */
    public function __invoke(mixed $rootvalue, array $input)
    {
        $searchEngine = core()->getConfigData('catalog.products.search.engine') === 'elastic'
            ? core()->getConfigData('catalog.products.search.admin_mode')
            : 'database';

        $products = $searchEngine === 'elastic'
            ? $this->searchFromElastic($input)
            : $this->searchFromDatabase($input);

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
        $prefix = DB::getTablePrefix();

        $qb = $this->productRepository->distinct()
            ->select('products.*')
            ->leftJoin('products as variants', DB::raw('COALESCE('.$prefix.'variants.parent_id, '.$prefix.'variants.id)'), '=', 'products.id');

        if (! empty($params['id'])) {
            $qb->where('products.id', $params['id']);
        }

        if (! empty($params['type'])) {
            $qb->where('products.type', $params['type']);
        }

        if (! empty($params['sku'])) {
            $qb->where('products.sku', 'like', '%'.$params['sku'].'%');
        }

        if (! empty($params['parent_id'])) {
            $qb->where('products.parent_id', $params['parent_id']);
        }

        if (! empty($params['attribute_family_id'])) {
            $qb->where('products.attribute_family_id', $params['attribute_family_id']);
        }

        if (
            ! empty($params['channel'])
            || ! empty($params['name'])
        ) {
            $qb->leftJoin('product_flat as product_flat', 'products.id', '=', 'product_flat.product_id');

            if (! empty($params['channel'])) {
                $qb->where('product_flat.channel', $params['channel']);
            }

            if (! empty($params['name'])) {
                $qb->where('product_flat.name', 'like', '%'.$params['name'].'%');
            }
        }

        $qb = $qb->groupBy('products.id');

        return $qb->paginate($params['limit'] ?? 10, ['*'], 'page', $params['page'] ?? 1);
    }

    /**
     * Search product from elastic search.
     *
     * @return \Illuminate\Support\Collection
     */
    public function searchFromElastic(array $params = [])
    {
        $channelCodes = $params['channel'] ?? core()->getAllChannels()->pluck('code')->toArray();

        $indexNames = collect($channelCodes)->map(fn ($channelCode) => 'products_'.$channelCode.'_'.app()->getLocale().'_index')->toArray();

        $results = Elasticsearch::search([
            'index' => $indexNames,
            'body'  => [
                'from'          => ($params['page'] * $params['limit']) - $params['limit'],
                'size'          => $params['limit'],
                'stored_fields' => [],
                'query'         => [
                    'bool' => $this->getElasticFilters($params ?? []) ?: new \stdClass,
                ],
                'sort'          => [
                    'id' => [
                        'order' => 'desc',
                    ],
                ],
            ],
        ]);

        $ids = collect($results['hits']['hits'])->pluck('_id')->toArray();

        $query = $this->productRepository
            ->whereIn('id', $ids)
            ->orderBy(DB::raw('FIELD(id, '.implode(',', $ids).')'));

        $total = $results['hits']['total']['value'];

        return new LengthAwarePaginator(
            $total ? $query->get() : [],
            $total,
            $params['limit'],
            $params['page']
        );
    }

    /**
     * Process request.
     */
    protected function getElasticFilters($params): array
    {
        $filters = [];

        foreach ($params as $attribute => $value) {
            if (in_array($attribute, ['channel', 'page', 'limit'])) {
                continue;
            }

            $filters['filter'][] = $this->getFilterValue($attribute, $value);
        }

        return $filters;
    }

    /**
     * Return applied filters
     */
    protected function getFilterValue(mixed $attribute, mixed $values): array
    {
        switch ($attribute) {
            case 'product_id':
                return [
                    'terms' => [
                        'id' => [$values],
                    ],
                ];

            case 'attribute_family':
                return [
                    'terms' => [
                        'attribute_family_id' => [$values],
                    ],
                ];

            case 'sku':
            case 'name':
                return [
                    'bool' => [
                        'should' => [
                            [
                                'match_phrase_prefix' => [
                                    $attribute => $values,
                                ],
                            ],
                        ],
                    ],
                ];

            default:
                return [
                    'terms' => [
                        $attribute => [$values],
                    ],
                ];
        }
    }
}
