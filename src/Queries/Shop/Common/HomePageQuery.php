<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Illuminate\Support\Str;
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

    public function getNewProducts($rootValue, array $args, GraphQLContext $context)
    {
        $count = isset($args['count']) ? $args['count'] : 4;

        $results = app(ProductRepository::class)->scopeQuery(function ($query) {
            $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

            $locale = request()->get('locale') ?: app()->getLocale();

            return $query->distinct()
                ->leftJoin('product_flat', 'products.id', '=', 'product_flat.product_id')
                ->addSelect('products.*')
                ->where('product_flat.status', 1)
                ->where('product_flat.visible_individually', 1)
                ->where('product_flat.new', 1)
                ->whereIn('products.type', ['simple', 'virtual', 'grouped', 'downloadable', 'bundle'])
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->inRandomOrder();
        })->paginate($count);

        return $results;
    }

    public function getFeaturedProducts($rootValue, array $args, GraphQLContext $context)
    {
        $count = isset($args['count']) ? $args['count'] : 4;

        $results = app(ProductRepository::class)->scopeQuery(function ($query) {
            $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

            $locale = request()->get('locale') ?: app()->getLocale();

            return $query->distinct()
                ->leftJoin('product_flat', 'products.id', '=', 'product_flat.product_id')
                ->addSelect('products.*')
                ->where('product_flat.status', 1)
                ->where('product_flat.visible_individually', 1)
                ->where('product_flat.featured', 1)
                ->whereIn('products.type', ['simple', 'virtual', 'grouped', 'downloadable', 'bundle'])
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->inRandomOrder();
        })->paginate($count);

        return $results;
    }

    public function getAllProducts($rootValue, array $args, GraphQLContext $context)
    {
        $count = isset($args['count']) ? $args['count'] : 4;

        $results = app(ProductRepository::class)->scopeQuery(function ($query) {
            $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

            $locale = request()->get('locale') ?: app()->getLocale();

            return $query->distinct()
                ->leftJoin('product_flat', 'products.id', '=', 'product_flat.product_id')
                ->addSelect('products.*')
                ->where('product_flat.status', 1)
                ->where('product_flat.visible_individually', 1)
                ->where('product_flat.featured', 1)
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->inRandomOrder();
        })->paginate($count);

        return $results;
    }

    public function getThemeCustomizationData($rootValue, array $args, GraphQLContext $context)
    {
        visitor()->visit();

        $customizations = $this->themeCustomizationRepository->orderBy('sort_order')->findWhere([
            'status'     => self::STATUS,
            'channel_id' => core()->getCurrentChannel()->id
        ]);

        $result = $customizations->map(function ($item) {
            $item->base_url = asset('');

            return $item;
        });

        return $result;
    }

    public function getCategories($rootValue, array $args, GraphQLContext $context)
    {
        $categoryId = isset($args['categoryId']) ? $args['categoryId'] : core()->getCurrentChannel()->root_category_id;

        $categorySlug = isset($args['categorySlug']) ? $args['categorySlug'] : '';

        if ($categorySlug) {
            $category = $this->categoryRepository->whereHas('translation', function ($q) use ($categorySlug) {
                $q->where('slug', 'like', '%' . urldecode($categorySlug) . '%');
            })->first();

            if (isset($category->id))
                $categoryId = $category->id;

        }

        return $this->categoryRepository->getVisibleCategoryTree($categoryId);
    }

    public function getvelocityMetaData($rootValue, array $args, GraphQLContext $context)
    {
        return $this->contentRepository->latest()->get();
    }

    public function advertisement($type, $advertisement)
    {
        $results = [];

        if ($type == 4 && isset($advertisement[4]) && is_array($advertisement[4])) {
            $advertisementFour = array_values(array_filter($advertisement[4]));
            foreach($advertisementFour as $key => $value) {
                $results[$key] = $value ? ['image' => Storage::url($value)] : '';
            }

            if (empty($results)) {
                $results[0] = ['image' => asset('/themes/velocity/assets/images/big-sale-banner.webp')];
                $results[1] = ['image' => asset('/themes/velocity/assets/images/seasons.webp')];
                $results[2] = ['image' => asset('/themes/velocity/assets/images/deals.webp')];
                $results[3] = ['image' => asset('/themes/velocity/assets/images/kids.webp')];
            }
        }

        if ($type == 3 &&  isset($advertisement[3]) && is_array($advertisement[3])) {
            $advertisementThree = array_values(array_filter($advertisement[3]));

            foreach($advertisementThree as $key => $value) {
                $results[$key] = $value ? ['image' => Storage::url($value)] : '';
            }

            if (empty($results)) {
               $results[0] = ['image' => asset('/themes/velocity/assets/images/headphones.webp')];
               $results[1] = ['image' => asset('/themes/velocity/assets/images/watch.webp')];
               $results[2] = ['image' => asset('/themes/velocity/assets/images/kids-2.webp')];
            }
        }

        if ($type == 2 &&  isset($advertisement[2]) && is_array($advertisement[2])) {
            $advertisementTwo = array_values(array_filter($advertisement[2]));

            foreach($advertisementTwo as $key => $value) {
                $results[$key] = $value ? ['image' => Storage::url($value)] : '';
            }

            if (empty($results)) {
                $results[0] = ['image' => asset('/themes/velocity/assets/images/toster.webp')];
                $results[1] = ['image' => asset('/themes/velocity/assets/images/trimmer.webp')];
            }
        }

        return $results;
    }
}
