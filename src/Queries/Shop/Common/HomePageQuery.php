<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Product\Repositories\ProductFlatRepository;
use Webkul\Core\Repositories\SliderRepository;
use Webkul\Velocity\Repositories\VelocityMetadataRepository;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Velocity\Repositories\ContentRepository;
use Webkul\Customer\Repositories\WishlistRepository;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class HomePageQuery extends BaseFilter
{
    /**
     * ProductRepository object
     *
     * @var \Webkul\Product\Repositories\ProductRepository
     */
    protected $productRepository;

    /**
     * ProductFlatRepository object
     *
     * @var \Webkul\Product\Repositories\ProductFlatRepository
     */
    protected $productFlatRepository;

    /**
     * ProductFlatRepository object
     *
     * @var \Webkul\Core\Repositories\SliderRepository
     */
    protected $sliderRepository;

    /**
     * ProductFlatRepository object
     *
     * @var \Webkul\Velocity\Repositories\VelocityMetadataRepository
     */
    protected $velocityMetadataRepository;

     /**
     * CategoryRepository object
     *
     * @var \Webkul\Category\Repositories\CategoryRepository
     */
    protected $categoryRepository;

    /**
     * ContentRepository object
     *
     * @var \Webkul\Velocity\Repositories\ContentRepository
     */
    protected $contentRepository;

     /**
     * ContentRepository object
     *
     * @var \Webkul\Customer\Repositories\WishlistRepository
     */
    protected $wishlistRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Product\Repositories\ProductRepository  $productRepository
     * @param  \Webkul\Product\Repositories\ProductFlatRepository  $productFlatRepository
     * @param  \Webkul\Core\Repositories\SliderRepository $sliderRepository
     * @param  \Webkul\Velocity\Repositories\VelocityMetadataRepository $velocityMetadataRepository
     * @param  \Webkul\Category\Repositories\CategoryRepository $categoryRepository
     * @param  \Webkul\Velocity\Repositories\ContentRepository $contentRepository
     * @param  \Webkul\Customer\Repositories\WishlistRepository $wishlistRepository
    * @return void
     */
    public function __construct(
        ProductRepository $productRepository,
        ProductFlatRepository $productFlatRepository,
        SliderRepository $sliderRepository,
        VelocityMetadataRepository $velocityMetadataRepository,
        CategoryRepository $categoryRepository,
        ContentRepository $contentRepository,
        WishlistRepository $wishlistRepository
    )
    {
        $this->productRepository = $productRepository;

        $this->productFlatRepository = $productFlatRepository;

        $this->sliderRepository = $sliderRepository;

        $this->velocityMetadataRepository = $velocityMetadataRepository;

        $this->categoryRepository = $categoryRepository;

        $this->contentRepository  = $contentRepository;

        $this->wishlistRepository = $wishlistRepository;
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
                ->whereIn('products.type', ['simple', 'virtual', 'configurable'])
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
                ->whereIn('products.type', ['simple', 'virtual', 'configurable'])
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->inRandomOrder();
        })->paginate($count);

        return $results;      
    }

    public function getSliders($rootValue, array $args, GraphQLContext $context)
    {
        return $this->sliderRepository->latest()->get();      
    }

    public function getAdvertisements($rootValue, array $args)
    {
        $data = [];
        
        if (core()->getCurrentChannel()->theme == 'velocity') {
            $advertisementRecord = $this->velocityMetadataRepository->where(['locale' => core()->getRequestedLocaleCode(), 'channel' => core()->getDefaultChannelCode()])->first();
            
            if ($advertisementRecord) {
                $advertisement = json_decode($advertisementRecord->advertisement, true);
                
                $advertisementFour = $this->advertisement(4, $advertisement);
                $advertisementThree = $this->advertisement(3, $advertisement);
                $advertisementTwo = $this->advertisement(2, $advertisement);

                $homeContent = preg_replace('/\s+/', '', $advertisementRecord->home_page_content);
                
                foreach (explode("@include", $homeContent) as $template) {
                    if (Str::contains($template, 'shop::home.advertisements.advertisement-four')
                    ) {
                        $advertisementFour = $this->getAdvertisementSlug("'shop::home.advertisements.advertisement-four',", $template, $advertisementFour);

                    } else if (Str::contains($template, 'shop::home.advertisements.advertisement-three')) {
                        $advertisementThree = $this->getAdvertisementSlug("'shop::home.advertisements.advertisement-three',", $template, $advertisementThree);
                        
                    } else if (Str::contains($template, 'shop::home.advertisements.advertisement-two')) {
                        $advertisementTwo = $this->getAdvertisementSlug("'shop::home.advertisements.advertisement-two',", $template, $advertisementTwo);
                    }
                }
                
                $data['advertisementFour'] = $advertisementFour;
                $data['advertisementThree'] = $advertisementThree;
                $data['advertisementTwo'] = $advertisementTwo;
            }
        } else {
            $data['advertisementFour'] = $data['advertisementTwo'] = [];
            $data['advertisementThree'] = [
                [
                    'image' => asset("/themes/default/assets/images/1.webp"),
                    'slug'  => null
                ],  [
                    'image' => asset("/themes/default/assets/images/2.webp"),
                    'slug'  => null
                ],  [
                    'image' => asset("/themes/default/assets/images/3.webp"),
                    'slug'  => null
                ],
            ];
        }
        
        return $data;
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

    public function getAdvertisementSlug($tempString, $template, $advertisement)
    {
        $trimString = trim(preg_replace('/\(+/', '', $template), ')');
        $findArray = explode($tempString, $trimString);

        if (count($findArray) > 1) {
            $indexArray = explode(",", str_replace(']', '', str_replace('[', '', $findArray[1])));

            foreach ($indexArray as $slugString) {
                $oneSlug = explode("'one'=>", $slugString); 
                $twoSlug = explode("'two'=>", $slugString);
                $threeSlug = explode("'three'=>", $slugString);
                $fourSlug = explode("'four'=>", $slugString);

                if (count($oneSlug) > 1)
                    $advertisement[0]['slug'] = str_replace("'", '', $oneSlug[1]);
                elseif (count($twoSlug) > 1)
                    $advertisement[1]['slug'] = str_replace("'", '', $twoSlug[1]);
                elseif (count($threeSlug) > 1)
                    $advertisement[2]['slug'] = str_replace("'", '', $threeSlug[1]);
                elseif (count($fourSlug) > 1)
                    $advertisement[3]['slug'] = str_replace("'", '', $fourSlug[1]);

            }
        }

        return $advertisement;
    }
}
