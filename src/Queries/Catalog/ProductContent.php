<?php

namespace Webkul\GraphQLAPI\Queries\Catalog;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Customer\Repositories\WishlistRepository;
use Webkul\Product\Helpers\View as ProductViewHelper;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class ProductContent extends BaseFilter
{
    /**
     * ProductRepository object
     *
     * @var \Webkul\Product\Repositories\ProductRepository
     */
    protected $productRepository;

    /**
     * WishlistRepository object
     *
     * @var \Webkul\Customer\Repositories\WishlistRepository
     */
    protected $wishlistRepository;

    /**
     * ProductViewHelper object
     *
     * @var \Webkul\Product\Helpers\View
     */
    protected $productViewHelper;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Product\Repositories\ProductRepository  $productRepository
     * @param  \Webkul\Customer\Repositories\WishlistRepository  $wishlistRepository
     * @param  \Webkul\Product\Helpers\View  $productViewHelper
     * @return void
     */
    public function __construct(
        ProductRepository $productRepository,
        WishlistRepository $wishlistRepository,
        ProductViewHelper $productViewHelper
    )
    {
        $this->productRepository = $productRepository;

        $this->wishlistRepository = $wishlistRepository;

        $this->productViewHelper = $productViewHelper;

        $this->_config = request('_config');
    }

    public function getAdditionalData($rootValue, array $args, GraphQLContext $context){
        return $this->productViewHelper->getAdditionalData($rootValue);
    }

    public function getRelatedProducts($rootValue, array $args, GraphQLContext $context)
    {
        $product = $this->productRepository->find($args['productId']);

        if ( $product ) {
            return $product->related_products()->where('type', 'simple')->get();
        }

        return null;
    }

    public function getProductPriceHtml($rootValue, array $args, GraphQLContext $context)
    {
        $priceArray = [
            'id'        => $rootValue->id,
            'type'      => $rootValue->type,
            'html'      => strip_tags($rootValue->getTypeInstance()->getPriceHtml($rootValue)),
            'regular'   => core()->currency($rootValue->getTypeInstance()->evaluatePrice($rootValue->price)),
            'special'   => ''
        ];

        switch ($rootValue->type) {
            case 'simple':
            case 'virtual':
            case 'downloadable':
                if ( $rootValue->getTypeInstance()->haveSpecialPrice() ) {
                    $priceArray['regular'] = core()->currency($rootValue->getTypeInstance()->evaluatePrice($rootValue->price));
                    $priceArray['special'] = core()->currency($rootValue->getTypeInstance()->evaluatePrice($rootValue->getTypeInstance()->getSpecialPrice()));
                }
                break;
            case 'configurable':
                $priceArray['regular'] = trans('shop::app.products.price-label') . ' ' . core()->currency($rootValue->getTypeInstance()->evaluatePrice($rootValue->getTypeInstance()->getMinimalPrice()));

                if ( $rootValue->getTypeInstance()->haveOffer() ) {
                    $priceArray['special'] = core()->currency($rootValue->getTypeInstance()->evaluatePrice($rootValue->getTypeInstance()->getOfferPrice()));
                }
                break;
            case 'grouped':
                $priceArray['regular'] = trans('shop::app.products.starting-at') . ' ' . core()->currency($rootValue->getTypeInstance()->getMinimalPrice());
                break;
            case 'bundle':
                $prices = $rootValue->getTypeInstance()->getProductPrices();
                $priceArray['regular'] = $priceArray['special'] = '';

                if ($prices['from']['regular_price']['price'] != $prices['from']['final_price']['price']) {
                    $priceArray['regular'] .= $prices['from']['regular_price']['formated_price'];
                    $priceArray['special'] .= $prices['from']['final_price']['formated_price'];
                } else {
                    $priceArray['regular'] .= $prices['from']['regular_price']['formated_price'];
                }

                if ($prices['from']['regular_price']['price'] != $prices['to']['regular_price']['price']
                    || $prices['from']['final_price']['price'] != $prices['to']['final_price']['price']
                ) {
                    $priceArray['regular'] .= ' To ';

                    if ($prices['to']['regular_price']['price'] != $prices['to']['final_price']['price']) {
                        $priceArray['regular'] .= $prices['to']['regular_price']['formated_price'];
                        $priceArray['special'] .= $prices['to']['final_price']['formated_price'];
                    } else {
                        $priceArray['regular'] .= $prices['to']['regular_price']['formated_price'];
                    }
                }
                
                break;
        }
        
        return $priceArray;
    }

    public function checkIsInWishlist($rootValue, array $args, GraphQLContext $context)
    {
        $wishlist = $this->wishlistRepository->findOneByField('product_id', $rootValue->id);

        if ( $wishlist ) {
            return true;
        }

        return false;
    }
}
