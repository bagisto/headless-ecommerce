<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Product;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Product\Repositories\{ProductRepository, ProductFlatRepository};
use Webkul\Product\Helpers\Toolbar;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class ProductListingQuery extends BaseFilter
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Attribute\Repositories\AttributeRepository  $attributeRepository
     * @param  \Webkul\Category\Repositories\CategoryRepository  $categoryRepository
     * @param  \Webkul\Customer\Repositories\CustomerRepository $customerRepository
     * @param  \Webkul\Product\Repositories\ProductRepository $productRepository
     * @param  \Webkul\Product\Repositories\ProductFlatRepository $productFlatRepository
     * @param  \Webkul\Product\Helpers\Toolbar $productHelperToolbar
     * @return void
     */
    public function __construct(
        protected AttributeRepository $attributeRepository,
        protected CategoryRepository $categoryRepository,
        protected CustomerRepository $customerRepository,
        protected ProductRepository $productRepository,
        protected ProductFlatRepository $productFlatRepository,
        protected Toolbar $productHelperToolbar,
    )
    {
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

        $product = $this->productFlatRepository->findOneWhere([
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
                $q->where('slug', 'like', '%'.urldecode($lastSlugs).'%');
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

            $availableSortOrders[$key] = [
                "key"      => $key,
                "title"    => $label['title'],
                "value"    => $label['value'],
                "sort"     => $label['sort'],
                "order"    => $label['order'],
                "position" => $label['position']
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
