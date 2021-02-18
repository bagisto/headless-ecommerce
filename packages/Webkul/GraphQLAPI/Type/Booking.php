<?php

namespace Webkul\GraphQLAPI\Type;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\BookingProduct\Helpers\Booking as BookingHelper;
use Webkul\BookingProduct\Repositories\BookingProductRepository;
use Webkul\Checkout\Models\CartItem;
use Webkul\Product\Datatypes\CartItemValidationResult;
use Webkul\Product\Helpers\ProductImage;
use Webkul\Product\Repositories\ProductAttributeValueRepository;
use Webkul\Product\Repositories\ProductImageRepository;
use Webkul\Product\Repositories\ProductInventoryRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Product\Type\Virtual;

class Booking extends Virtual
{
    /**
     * BookingProductRepository instance
     *
     * @var \Webkul\BookingProduct\Repositories\BookingProductRepository
     */
    protected $bookingProductRepository;

    /**
     * Booking helper instance
     *
     * @var \Webkul\BookingProduct\Helpers\Booking
     */
    protected $bookingHelper;

    /** @var bool do not allow booking products to be copied, it would be too complicated. */
    protected $canBeCopied = false;

    /**
     * @var array
     */
    protected $additionalViews = [
        'admin::catalog.products.accordians.images',
        'admin::catalog.products.accordians.categories',
        'admin::catalog.products.accordians.channels',
        'bookingproduct::admin.catalog.products.accordians.booking',
        'admin::catalog.products.accordians.product-links',
    ];

    /**
     * Create a new product type instance.
     *
     * @param  \Webkul\Attribute\Repositories\AttributeRepository           $attributeRepository
     * @param  \Webkul\Product\Repositories\ProductRepository               $productRepository
     * @param  \Webkul\Product\Repositories\ProductAttributeValueRepository $attributeValueRepository
     * @param  \Webkul\Product\Repositories\ProductInventoryRepository      $productInventoryRepository
     * @param  \Webkul\Product\Repositories\ProductImageRepository          $productImageRepository
     * @param  \Webkul\Product\Helpers\ProductImage $productImageHelper
     * @param  \Webkul\BookingProduct\Repositories\BookingProductRepository  $bookingProductRepository
     * @param  \Webkul\BookingProduct\Helpers\BookingHelper  $bookingHelper
     * @return void
     */
    public function __construct(
        AttributeRepository $attributeRepository,
        ProductRepository $productRepository,
        ProductAttributeValueRepository $attributeValueRepository,
        ProductInventoryRepository $productInventoryRepository,
        ProductImageRepository $productImageRepository,
        ProductImage $productImageHelper,
        BookingProductRepository $bookingProductRepository,
        BookingHelper $bookingHelper
    )
    {
        parent::__construct(
            $attributeRepository,
            $productRepository,
            $attributeValueRepository,
            $productInventoryRepository,
            $productImageRepository,
            $productImageHelper
        );

        $this->bookingProductRepository = $bookingProductRepository;

        $this->bookingHelper = $bookingHelper;
    }

    /**
     * @param  array  $data
     * @param  int  $id
     * @param  string  $attribute
     * @return \Webkul\Product\Contracts\Product
     */
    public function update(array $data, $id, $attribute = "id")
    {
        $product = parent::update($data, $id, $attribute);

        if (request()->route()->getName() != 'admin.catalog.products.massupdate') {
            $bookingProduct = $this->bookingProductRepository->findOneByField('product_id', $id);

            if ($bookingProduct) {
                $this->bookingProductRepository->update($data['booking'], $bookingProduct->id);
            } else {
                $this->bookingProductRepository->create(array_merge($data['booking'], [
                    'product_id' => $id,
                ]));
            }
        }

        return $product;
    }
}
