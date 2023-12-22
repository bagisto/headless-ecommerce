<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Illuminate\Support\Facades\Storage;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Product\Repositories\ProductFlatRepository;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Customer\Repositories\WishlistRepository;
use Webkul\GraphQLAPI\Queries\BaseFilter;
use Webkul\Shop\Repositories\ThemeCustomizationRepository;

class HomePageQuery extends BaseFilter
{
       /**
     * Using const variable for status
     */
    const STATUS = 1;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Product\Repositories\ProductRepository  $productRepository
     * @param  \Webkul\Product\Repositories\ProductFlatRepository  $productFlatRepository
     * @param  \Webkul\Velocity\Repositories\VelocityMetadataRepository $velocityMetadataRepository
     * @param  \Webkul\Category\Repositories\CategoryRepository $categoryRepository
     * @param  \Webkul\Velocity\Repositories\ContentRepository $contentRepository
     * @param  \Webkul\Customer\Repositories\WishlistRepository $wishlistRepository
    * @return void
     */
    public function __construct(
        protected ProductRepository $productRepository,
        protected ProductFlatRepository $productFlatRepository,
        protected ThemeCustomizationRepository $themeCustomizationRepository,
        protected CategoryRepository $categoryRepository,
        protected WishlistRepository $wishlistRepository
    )
    {
    }

    public function getDefaultChannel($rootValue, array $args, GraphQLContext $context)
    {
        return core()->getDefaultChannel();
    }

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

    public function getCategories($rootValue, array $args, GraphQLContext $context)
    {
        $params = $args['input'];

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

        return $categories;
    }

    public function getAllProducts($rootValue, array $args, GraphQLContext $context)
    {
        $count = isset($args['count']) ? $args['count'] : 4;

        $allowedProductsType = ['simple', 'virtual', 'grouped', 'downloadable', 'bundle', 'configurable'];

        $results = app(ProductRepository::class)->scopeQuery(function ($query, $allowedProductsType) {
            $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

            $locale = request()->get('locale') ?: app()->getLocale();

            return $query->distinct()
                ->leftJoin('product_flat', 'products.id', '=', 'product_flat.product_id')
                ->addSelect('products.*')
                ->where('product_flat.status', 1)
                ->where('product_flat.visible_individually', 1)
                ->where('product_flat.featured', 1)
                ->whereIn('products.type', $allowedProductsType)
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->inRandomOrder();
        })->paginate($count);

        return $results;
    }
}
