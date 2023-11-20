<?php

namespace Webkul\GraphQLAPI\Queries\Catalog;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Customer\Repositories\WishlistRepository;
use Webkul\GraphQLAPI\Queries\BaseFilter;
use Webkul\Product\Helpers\ConfigurableOption as ProductConfigurableHelper;
use Webkul\Product\Helpers\View as ProductViewHelper;
use Webkul\Product\Helpers\Review;
use Webkul\Product\Repositories\ProductRepository;

class ProductContent extends BaseFilter
{
    /**
     * Contains route related configuration.
     *
     * @var array
     */
    protected $_config;

    /**
     * Contains current guard
     *
     * @var array
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Product\Repositories\ProductRepository  $productRepository
     * @param  \Webkul\Customer\Repositories\WishlistRepository  $wishlistRepository
     * @param  \Webkul\Product\Helpers\View  $productViewHelper
     * @param  \Webkul\Product\Helpers\Review  $review
     * @param  \Webkul\Product\Helpers\ConfigurableOption  $productConfigurableHelper
     * @return void
     */
    public function __construct(
        protected ProductRepository $productRepository,
        protected WishlistRepository $wishlistRepository,
        protected ProductViewHelper $productViewHelper,
        protected Review $review,
        protected ProductConfigurableHelper $productConfigurableHelper
    ) {
        $this->guard = 'api';
        
        $this->_config = request('_config');
    }

    /**
     * Get additional data.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return mixed
     */
    public function getAdditionalData($rootValue, array $args, GraphQLContext $context)
    {
        return $this->productViewHelper->getAdditionalData($rootValue);
    }

    /**
     * Get related products.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return mixed
     */
    public function getRelatedProducts($rootValue, array $args, GraphQLContext $context)
    {
        $product = $this->productRepository->find($args['productId']);

        if ($product) {
            return $product->related_products()->whereIn('products.type', ['simple', 'virtual', 'configurable'])->get();
        }

        return null;
    }

    /**
     * Get product price html.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return array
     */
    public function getProductPriceHtml($rootValue, array $args, GraphQLContext $context)
    {
        $priceArray = [
            'id'                         => $rootValue->id,
            'type'                       => $rootValue->type,
            'html'                       => strip_tags($rootValue->getTypeInstance()->getPriceHtml($rootValue)),
            'regular'                    => core()->currency($rootValue->getTypeInstance()->evaluatePrice($rootValue->price)),
            'regularWithoutCurrencyCode' => $rootValue->getTypeInstance()->evaluatePrice($rootValue->price),
            'special'                    => '',
            'specialWithoutCurrencyCode' => '',
            'currencyCode'               => core()->getCurrentCurrency()->code,
        ];

        switch ($rootValue->type) {
            case 'simple':
            case 'virtual':
            case 'downloadable':
                if ($rootValue->getTypeInstance()->haveDiscount()) {
                    $priceArray['regular'] = core()->currency($rootValue->getTypeInstance()->evaluatePrice($rootValue->price));
                    $priceArray['regularWithoutCurrencyCode'] = $rootValue->getTypeInstance()->evaluatePrice($rootValue->price);
                    $priceArray['special'] = core()->currency($rootValue->getTypeInstance()->evaluatePrice($rootValue->getTypeInstance()->getSpecialPrice()));
                    $priceArray['specialWithoutCurrencyCode'] = $rootValue->getTypeInstance()->evaluatePrice($rootValue->getTypeInstance()->getSpecialPrice());
                }
                break;

            case 'configurable':
                $priceArray['regular'] = trans('shop::app.products.price-label') . ' ' . core()->currency($rootValue->getTypeInstance()->evaluatePrice($rootValue->getTypeInstance()->getMinimalPrice()));
                $priceArray['regularWithoutCurrencyCode'] = $rootValue->getTypeInstance()->evaluatePrice($rootValue->getTypeInstance()->getMinimalPrice());

                if ($rootValue->getTypeInstance()->getMinimalPrice()) {
                    $priceArray['special'] = core()->currency($rootValue->getTypeInstance()->evaluatePrice($rootValue->getTypeInstance()->getMinimalPrice()));
                    $priceArray['specialWithoutCurrencyCode'] = $rootValue->getTypeInstance()->evaluatePrice($rootValue->getTypeInstance()->getMinimalPrice());
                }
                break;

            case 'grouped':
                $priceArray['regular'] = trans('shop::app.products.starting-at') . ' ' . core()->currency($rootValue->getTypeInstance()->getMinimalPrice());
                $priceArray['regularWithoutCurrencyCode'] = $rootValue->getTypeInstance()->getMinimalPrice();
                break;

            case 'bundle':
                $prices = $rootValue->getTypeInstance()->getProductPrices();
                $priceArray['regular'] = $priceArray['special'] = '';

                /**
                 * Not in use.
                 */
                $priceArray['regularWithoutCurrencyCode'] = $priceArray['specialWithoutCurrencyCode'] = '';

                if ($prices['from']['regular']['price'] != $prices['from']['final']['price']) {
                    $priceArray['regular'] .= $prices['from']['regular']['formatted_price'];
                    $priceArray['special'] .= $prices['from']['final']['formatted_price'];
                } else {
                    $priceArray['regular'] .= $prices['from']['regular']['formatted_price'];
                }

                if ($prices['from']['regular']['price'] != $prices['to']['regular']['price']
                    || $prices['from']['final']['price'] != $prices['to']['final']['price']
                ) {
                    $priceArray['regular'] .= ' To ';

                    if ($prices['to']['regular']['price'] != $prices['to']['final']['price']) {
                        $priceArray['regular'] .= $prices['to']['regular']['formatted_price'];
                        $priceArray['special'] .= $prices['to']['final']['formatted_price'];
                    } else {
                        $priceArray['regular'] .= $prices['to']['regular']['formatted_price'];
                    }
                }
                break;
        }

        return $priceArray;
    }

    /**
     * Check wishlist
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return bool
     */
    public function checkIsInWishlist($rootValue, array $args, GraphQLContext $context)
    {
        if ( bagisto_graphql()->guard($this->guard)->check() ) {
            $customer = bagisto_graphql()->guard($this->guard)->user();

            $wishlist = $this->wishlistRepository->findOneWhere([
                'customer_id'   => $customer->id,
                'product_id'    => $rootValue->id
            ]);

            if ($wishlist) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check product is in sale
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return bool
     */
    public function checkIsInSale($rootValue, array $args, GraphQLContext $context)
    {
        $productTypeInstance = $rootValue->getTypeInstance();

        if ($productTypeInstance->haveDiscount()) {
            return true;
        }

        return false;
    }

    /**
     * Get configurable data.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return mixed
     */
    public function getConfigurableData($rootValue, array $args, GraphQLContext $context)
    {
        $data = $this->productConfigurableHelper->getConfigurationConfig($this->productRepository->find($rootValue->id));

        $index = [];
        foreach ($data['index'] as $key => $attributeOptionsIds) {
            if (! isset($index[$key])) {
                $index[$key] = [
                    'id'                 => $key,
                    'attributeOptionIds' => [],
                ];
            }

            foreach ($attributeOptionsIds as $attributeId => $optionId) {
                if ($optionId) {
                    $optionData = [
                        'attributeId'       => $attributeId,
                        'attributeCode'     => '',
                        'attributeOptionId' => $optionId,
                    ];
                    
                    foreach ($data['attributes'] as $attribute) {
                        if ($attribute['id'] == $attributeId) {
                            $optionData['attributeCode'] = $attribute['code'];
                            break;
                        }
                    }

                    $index[$key]['attributeOptionIds'][] = $optionData;
                }
            }
        }
        $data['index'] = $index;

        $variant_prices = [];
        foreach ($data['variant_prices'] as $key => $prices) {
            $variant_prices[$key] = [
                'id'            => $key,
                'regular' => $prices['regular'],
                'final'   => $prices['final'],
            ];
        }
        $data['variant_prices'] = $variant_prices;

        $variant_images = [];
        foreach ($data['variant_images'] as $key => $imgs) {
            $variant_images[$key] = [
                'id'     => $key,
                'images' => [],
            ];

            foreach ($imgs as $img_index => $urls) {
                $variant_images[$key]['images'][$img_index] = $urls;
            }
        }
        $data['variant_images'] = $variant_images;

        $variant_videos = [];
        foreach ($data['variant_videos'] as $key => $imgs) {
            $variant_videos[$key] = [
                'id'     => $key,
                'videos' => [],
            ];

            foreach ($imgs as $img_index => $urls) {
                $variant_videos[$key]['videos'][$img_index] = $urls;
            }
        }
        $data['variant_videos'] = $variant_videos;

        return $data;
    }

    /**
     * Get cached gallery images.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return mixed
     */
    public function getCacheGalleryImages($rootValue, array $args, GraphQLContext $context)
    {
        return product_image()->getGalleryImages($rootValue);
    }

    /**
     * Get product's review list.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return mixed
     */
    public function getReviews($rootValue, array $args, GraphQLContext $context)
    {
        $product = $this->productRepository->find($rootValue->id);

        if ($product) {
            return $product->reviews->where('status', 'approved');
        }

        return [];
    }

    /**
     * Get product base image.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return mixed
     */
    public function getProductBaseImage($rootValue, array $args, GraphQLContext $context)
    {
        return product_image()->getProductBaseImage($rootValue);
    }

    /**
     * Get product avarage rating.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return string
     */
    public function getAverageRating($rootValue, array $args, GraphQLContext $context)
    {
        return $this->review->getAverageRating($rootValue);
    }

    /**
     * Get product percentage rating.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return array
     */
    public function getPercentageRating($rootValue, array $args, GraphQLContext $context)
    {
        return $this->review->getPercentageRating($rootValue);
    }

    /**
     * Get product share URL.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return mixed
     */
    public function getProductShareUrl($rootValue, array $args, GraphQLContext $context)
    {
        return route('shop.product_or_category.index', $rootValue->url_key);
    }
}
