<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Catalog\Products;

use Webkul\Customer\Repositories\WishlistRepository;
use Webkul\GraphQLAPI\Queries\BaseFilter;
use Webkul\Product\Helpers\ConfigurableOption as ProductConfigurableHelper;
use Webkul\Product\Helpers\Review as ProductReviewHelper;
use Webkul\Product\Helpers\View as ProductViewHelper;
use Webkul\Product\Repositories\ProductRepository;

class ProductContent extends BaseFilter
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected WishlistRepository $wishlistRepository,
        protected ProductViewHelper $productViewHelper,
        protected ProductReviewHelper $productReviewHelper,
        protected ProductConfigurableHelper $productConfigurableHelper
    ) {}

    /**
     * Get product details.
     *
     * @return array
     */
    public function getAdditionalData($product)
    {
        return $this->productViewHelper->getAdditionalData($product);
    }

    /**
     * Get product price html.
     *
     * @return array
     */
    public function getProductPriceHtml($product)
    {
        $productType = $product->getTypeInstance();

        $priceArray = [
            'id'                         => $product->id,
            'type'                       => $product->type,
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

        switch ($product->type) {
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
     * @return array
     */
    public function getBundleProductPrice($data)
    {
        $product = app(ProductRepository::class)->find($data['id']);

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
     * Check product is in wishlist.
     */
    public function checkIsInWishlist($product): bool
    {
        if (! auth()->guard('api')->check()) {
            return false;
        }

        return (bool) $this->wishlistRepository->where([
            'customer_id' => auth()->guard('api')->user()->id,
            'product_id'  => $product->id,
        ])->count();
    }

    /**
     * Check product is in sale
     *
     * @return bool
     */
    public function checkIsInSale($product)
    {
        $productTypeInstance = $product->getTypeInstance();

        if ($productTypeInstance->haveDiscount()) {
            return true;
        }

        return false;
    }

    /**
     * Check product is in stock
     */
    public function checkIsSaleable($product): bool
    {
        return $product->getTypeInstance()->isSaleable();
    }

    /**
     * Get configurable data.
     *
     * @return mixed
     */
    public function getConfigurableData($product)
    {
        $data = $this->productConfigurableHelper->getConfigurationConfig($product);

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
     * @return mixed
     */
    public function getCacheGalleryImages($product)
    {
        return product_image()->getGalleryImages($product);
    }

    /**
     * Get product's review list.
     *
     * @return mixed
     */
    public function getReviews($product)
    {
        return $product->reviews->where('status', 'approved');
    }

    /**
     * Get product base image.
     *
     * @return mixed
     */
    public function getProductBaseImage($product)
    {
        themes()->set('default');

        return product_image()->getProductBaseImage($product);
    }

    /**
     * Get product avarage rating.
     *
     * @return string
     */
    public function getAverageRating($product)
    {
        return $this->productReviewHelper->getAverageRating($product);
    }

    /**
     * Get product percentage rating.
     *
     * @return array
     */
    public function getPercentageRating($product)
    {
        return $this->productReviewHelper->getPercentageRating($product);
    }

    /**
     * Get product share URL.
     */
    public function getProductShareUrl($product): ?string
    {
        return $product->url_key
            ? route('shop.product_or_category.index', $product->url_key)
            : null;
    }
}
