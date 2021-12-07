<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Product\Repositories\ProductFlatRepository;
use Webkul\Core\Repositories\SliderRepository;
use Webkul\Velocity\Repositories\VelocityMetadataRepository;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Velocity\Repositories\ContentRepository;
use Webkul\Customer\Repositories\WishlistRepository;
use Cart;
use Elasticsearch\Endpoints\Cluster\Reroute;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class HomePageQuery extends BaseFilter
{
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
     * @param  \Webkul\Product\Repositories\ProductFlatRepository  $productFlatRepository
     * @param  \Webkul\Core\Repositories\SliderRepository $sliderRepository
     * @param  \Webkul\Velocity\Repositories\VelocityMetadataRepository $velocityMetadataRepository
     * @param  \Webkul\Category\Repositories\CategoryRepository $categoryRepository
     * @param  \Webkul\Velocity\Repositories\ContentRepository $contentRepository
     * @param  \Webkul\Customer\Repositories\WishlistRepository $wishlistRepository
    * @return void
     */
    public function __construct(
        ProductFlatRepository $productFlatRepository,
        SliderRepository $sliderRepository,
        VelocityMetadataRepository $velocityMetadataRepository,
        CategoryRepository $categoryRepository,
        ContentRepository $contentRepository,
        WishlistRepository $wishlistRepository
    )
    {
        $this->productFlatRepository = $productFlatRepository;

        $this->sliderRepository = $sliderRepository;

        $this->velocityMetadataRepository = $velocityMetadataRepository;

        $this->categoryRepository = $categoryRepository;

        $this->contentRepository  = $contentRepository;

        $this->wishlistRepository = $wishlistRepository;
    }

    public function getNewProducts($rootValue, array $args, GraphQLContext $context){

        $count = isset($args['count']) ? $args['count'] : 4;

        $results = app(ProductFlatRepository::class)->scopeQuery(function ($query) {
            $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

            $locale = request()->get('locale') ?: app()->getLocale();

            return $query->distinct()
                ->addSelect('product_flat.*')
                ->where('product_flat.status', 1)
                ->where('product_flat.visible_individually', 1)
                ->where('product_flat.new', 1)
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->inRandomOrder();
        })->paginate($count);

        return $results;      
    }

    public function getFeaturedProducts($rootValue, array $args, GraphQLContext $context){

        $count = isset($args['count']) ? $args['count'] : 4;

        $results = app(ProductFlatRepository::class)->scopeQuery(function ($query) {
            $channel = request()->get('channel') ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

            $locale = request()->get('locale') ?: app()->getLocale();

            return $query->distinct()
                ->addSelect('product_flat.*')
                ->where('product_flat.status', 1)
                ->where('product_flat.visible_individually', 1)
                ->where('product_flat.featured', 1)
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->inRandomOrder();
        })->paginate($count);

        return $results;      
    }

    public function getSliders($rootValue, array $args, GraphQLContext $context) {

        return $this->sliderRepository->latest()->get();      
    }

    public function getAdvertisements($rootValue, array $args) {

        $data= [];
    
       foreach($this->velocityMetadataRepository->latest()->get() as $keys => $metaData) {

            $advertisement = json_decode($metaData->advertisement, true);

            $data[$keys]["advertisementFour"] = $this->advertisement(4, $advertisement);

            $data[$keys]["advertisementThree"] = $this->advertisement(3, $advertisement);

            $data[$keys]["advertisementTwo"] = $this->advertisement(2, $advertisement);
       }
      
       return $data;
    }

    public function getCategories($rootValue, array $args, GraphQLContext $context) {
        return $this->categoryRepository->getVisibleCategoryTree(core()->getCurrentChannel()->root_category_id);
    }

    public function getvelocityMetaData($rootValue, array $args, GraphQLContext $context) {
        return $this->contentRepository->latest()->get();
    }

    public function advertisement($type, $advertisement) {

        $results = [];

        if ($type == 4 && isset($advertisement[4]) && is_array($advertisement[4])) {
            $advertisementFour = array_values(array_filter($advertisement[4]));
           foreach($advertisementFour as $key => $value) {
               $results[$key]["path"] = $value;
           }
       }

       if ($type == 3 &&  isset($advertisement[3]) && is_array($advertisement[3])) {
           $advertisementThree = array_values(array_filter($advertisement[3]));

           foreach($advertisementThree as $key => $value) {
               $results[$key]["path"] = $value;
           }
       }

       if ($type == 2 &&  isset($advertisement[2]) && is_array($advertisement[2])) {
           $advertisementTwo = array_values(array_filter($advertisement[2]));

           foreach($advertisementTwo as $key => $value) {
               $results[$key]["path"] = $value;
           }
       }

       return $results;
    }
}



