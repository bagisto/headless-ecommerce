<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Catalog\Products;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Customer\Repositories\WishlistRepository;
use Webkul\GraphQLAPI\Queries\BaseFilter;
use Webkul\Product\Helpers\ConfigurableOption as ProductConfigurableHelper;
use Webkul\Product\Helpers\Review;
use Webkul\Product\Helpers\View as ProductViewHelper;
use Webkul\Product\Repositories\ProductRepository;

class ProductContent extends BaseFilter
{
    /**
     * Contains current guard
     *
     * @var array
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
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
    }

    /**
     * Get additional data.
     *
     * @param  mixed  $rootValue
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
     * @return array
     */
    public function getProductPriceHtml($rootValue, array $args, GraphQLContext $context)
    {
        $productType = $rootValue->getTypeInstance();

        $priceArray = [
            'id'                         => $rootValue->id,
            'type'                       => $rootValue->type,
            'priceHtml'                  => $productType->getPriceHtml(),
            'priceWithoutHtml'           => strip_tags($productType->getPriceHtml()),
            'minPrice'                   => core()->formatPrice($productType->getMinimalPrice()),
            'regularPrice'               => '',
            'formattedRegularPrice'      => '',
            'finalPrice'                 => '',
            'formattedFinalPrice'        => '',
            'currencyCode'               => core()->getCurrentCurrency()->code,
        ];

        $regularPrice = $productType->getProductPrices();

        switch ($rootValue->type) {
            case 'simple':
            case 'virtual':
            case 'downloadable':
            case 'grouped':

                $priceArray['finalPrice'] = $regularPrice['final']['price'];
                $priceArray['formattedFinalPrice'] = $regularPrice['final']['formatted_price'];
                $priceArray['regularPrice'] = $regularPrice['regular']['price'];
                $priceArray['formattedRegularPrice'] = $regularPrice['regular']['formatted_price'];

                break;
            case 'configurable':

                $priceArray['regularPrice'] = $regularPrice['regular']['price'];
                $priceArray['formattedRegularPrice'] = $regularPrice['regular']['formatted_price'];

                break;

            case 'bundle':
                $priceArray['finalPrice'] = '';
                $priceArray['formattedFinalPrice'] = '';
                $priceArray['regularPrice'] = '';
                $priceArray['formattedRegularPrice'] = '';

                /**
                 * Not in use.
                 */
                $priceArray['regularWithoutCurrencyCode'] = $priceArray['specialWithoutCurrencyCode'] = '';

                if ($regularPrice['from']['regular']['price'] != $regularPrice['from']['final']['price']) {
                    $priceArray['finalPrice'] = $regularPrice['from']['final']['price'];
                    $priceArray['formattedFinalPrice'] = $regularPrice['from']['final']['formatted_price'];
                    $priceArray['regularPrice'] = $regularPrice['from']['regular']['price'];
                    $priceArray['formattedRegularPrice'] = $regularPrice['from']['regular']['formatted_price'];
                } else {
                    $priceArray['regularPrice'] .= $regularPrice['from']['regular']['price'];
                    $priceArray['formattedRegularPrice'] .= $regularPrice['from']['regular']['formatted_price'];
                }

                if ($regularPrice['from']['regular']['price'] != $regularPrice['to']['regular']['price']
                    || $regularPrice['from']['final']['price'] != $regularPrice['to']['final']['price']
                ) {
                    $priceArray['regularPrice'] .= ' To ';
                    $priceArray['formattedRegularPrice'] .= ' To ';
                    $priceArray['finalPrice'] .= ' To ';
                    $priceArray['formattedFinalPrice'] .= ' To ';

                    if ($regularPrice['to']['regular']['price'] != $regularPrice['to']['final']['price']) {
                        $priceArray['finalPrice'] .= $regularPrice['to']['final']['price'];
                        $priceArray['formattedFinalPrice'] .= $regularPrice['to']['final']['formatted_price'];
                        $priceArray['regularPrice'] .= $regularPrice['to']['regular']['price'];
                        $priceArray['formattedRegularPrice'] .= $regularPrice['to']['regular']['formatted_price'];
                    } else {
                        $priceArray['regularPrice'] .= $regularPrice['to']['regular']['price'];
                        $priceArray['formattedRegularPrice'] .= $regularPrice['to']['regular']['formatted_price'];
                    }
                }
                break;
        }

        return $priceArray;
    }

    /**
     * Get bundle type product price.
     *
     * @param  mixed  $rootValue
     * @return array
     */
    public function getBundleProductPrice($rootValue, array $args, GraphQLContext $context)
    {
        $product = $this->productRepository->find($rootValue['id']);

        $priceArray = [
            'finalPriceFrom'            => '',
            'formattedFinalPriceFrom'   => '',
            'regularPriceFrom'          => '',
            'formattedRegularPriceFrom' => '',
            'finalPriceTo'              => '',
            'formattedFinalPriceTo'     => '',
            'regularPriceTo'            => '',
            'formattedRegularPriceTo'   => '',
        ];

        $regularPrice = $product->getTypeInstance()->getProductPrices();

        if ($product->type == 'bundle') {
            $priceArray['finalPriceFrom'] = $regularPrice['from']['final']['price'];
            $priceArray['formattedFinalPriceFrom'] = $regularPrice['from']['final']['formatted_price'];
            $priceArray['regularPriceFrom'] = $regularPrice['from']['regular']['price'];
            $priceArray['formattedRegularPriceFrom'] = $regularPrice['from']['regular']['formatted_price'];
            $priceArray['finalPriceTo'] = $regularPrice['to']['final']['price'];
            $priceArray['formattedFinalPriceTo'] = $regularPrice['to']['final']['formatted_price'];
            $priceArray['regularPriceTo'] = $regularPrice['to']['regular']['price'];
            $priceArray['formattedRegularPriceTo'] = $regularPrice['to']['regular']['formatted_price'];
        }

        return $priceArray;
    }

    /**
     * Check wishlist
     *
     * @param  mixed  $rootValue
     * @return bool
     */
    public function checkIsInWishlist($rootValue, array $args, GraphQLContext $context)
    {
        if (auth()->check()) {
            $wishlist = $this->wishlistRepository->findOneWhere([
                'customer_id' => auth()->user()->id,
                'product_id'  => $rootValue->id,
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

    public function checkIsSaleable($rootValue, array $args, GraphQLContext $context): bool
    {
        return $rootValue->getTypeInstance()
            ->isSaleable();
    }

    /**
     * Get configurable data.
     *
     * @param  mixed  $rootValue
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

        $variantPrices = [];
        foreach ($data['variant_prices'] as $key => $prices) {
            $variantPrices[$key] = [
                'id'            => $key,
                'regular'       => $prices['regular'],
                'final'         => $prices['final'],
            ];
        }
        $data['variant_prices'] = $variantPrices;

        $variantImages = [];
        foreach ($data['variant_images'] as $key => $imgs) {
            $variantImages[$key] = [
                'id'     => $key,
                'images' => [],
            ];

            foreach ($imgs as $img_index => $urls) {
                $variantImages[$key]['images'][$img_index] = $urls;
            }
        }
        $data['variant_images'] = $variantImages;

        $variantVideos = [];
        foreach ($data['variant_videos'] as $key => $imgs) {
            $variantVideos[$key] = [
                'id'     => $key,
                'videos' => [],
            ];

            foreach ($imgs as $img_index => $urls) {
                $variantVideos[$key]['videos'][$img_index] = $urls;
            }
        }
        $data['variant_videos'] = $variantVideos;

        return $data;
    }

    /**
     * Get cached gallery images.
     *
     * @param  mixed  $rootValue
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
     * @return mixed
     */
    public function getProductBaseImage($rootValue, array $args, GraphQLContext $context)
    {
        themes()->set('default');

        return product_image()->getProductBaseImage($rootValue);
    }

    /**
     * Get product avarage rating.
     *
     * @param  mixed  $rootValue
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
     * @return mixed
     */
    public function getProductShareUrl($rootValue, array $args, GraphQLContext $context)
    {
        return route('shop.product_or_category.index', $rootValue->url_key);
    }
}
