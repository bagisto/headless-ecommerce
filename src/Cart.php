<?php

namespace Webkul\GraphQLAPI;

use Exception;
use Illuminate\Support\Facades\Auth;
use Webkul\Checkout\Cart as BaseCart;
use Illuminate\Support\Arr;
use Webkul\Tax\Helpers\Tax;
use Illuminate\Support\Facades\Event;
use Webkul\Shipping\Facades\Shipping;
use Webkul\Checkout\Models\CartAddress;
use Webkul\Checkout\Models\CartPayment;
use Webkul\Checkout\Models\Cart as CartModel;
use Webkul\Checkout\Repositories\CartRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Tax\Repositories\TaxCategoryRepository;
use Webkul\Checkout\Repositories\CartItemRepository;
use Webkul\Customer\Repositories\WishlistRepository;
use Webkul\Checkout\Repositories\CartAddressRepository;
use Webkul\Customer\Repositories\CustomerAddressRepository;

class Cart extends BaseCart
{
    /**
     * CartRepository instance
     *
     * @var \Webkul\Checkout\Repositories\CartRepository
     */
    protected $cartRepository;

    /**
     * CartItemRepository instance
     *
     * @var \Webkul\Checkout\Repositories\CartItemRepository
     */
    protected $cartItemRepository;

    /**
     * CartAddressRepository instance
     *
     * @var \Webkul\Checkout\Repositories\CartAddressRepository
     */
    protected $cartAddressRepository;

    /**
     * ProductRepository instance
     *
     * @var \Webkul\Checkout\Repositories\ProductRepository
     */
    protected $productRepository;

    /**
     * TaxCategoryRepository instance
     *
     * @var \Webkul\Tax\Repositories\TaxCategoryRepository
     */
    protected $taxCategoryRepository;

    /**
     * WishlistRepository instance
     *
     * @var \Webkul\Customer\Repositories\WishlistRepository
     */
    protected $wishlistRepository;

    /**
     * CustomerAddressRepository instance
     *
     * @var \Webkul\Customer\Repositories\CustomerAddressRepository
     */
    protected $customerAddressRepository;

    /**
     * Create a new class instance.
     *
     * @param  \Webkul\Checkout\Repositories\CartRepository             $cartRepository
     * @param  \Webkul\Checkout\Repositories\CartItemRepository         $cartItemRepository
     * @param  \Webkul\Checkout\Repositories\CartAddressRepository      $cartAddressRepository
     * @param  \Webkul\Product\Repositories\ProductRepository           $productRepository
     * @param  \Webkul\Tax\Repositories\TaxCategoryRepository           $taxCategoryRepository
     * @param  \Webkul\Customer\Repositories\WishlistRepository         $wishlistRepository
     * @param  \Webkul\Customer\Repositories\CustomerAddressRepository  $customerAddressRepository
     * @return void
     */
    public function __construct(
        CartRepository $cartRepository,
        CartItemRepository $cartItemRepository,
        CartAddressRepository $cartAddressRepository,
        ProductRepository $productRepository,
        TaxCategoryRepository $taxCategoryRepository,
        WishlistRepository $wishlistRepository,
        CustomerAddressRepository $customerAddressRepository
    )
    {
        $this->cartRepository = $cartRepository;

        $this->cartItemRepository = $cartItemRepository;

        $this->cartAddressRepository = $cartAddressRepository;

        $this->productRepository = $productRepository;

        $this->taxCategoryRepository = $taxCategoryRepository;

        $this->wishlistRepository = $wishlistRepository;

        $this->customerAddressRepository = $customerAddressRepository;

        parent::__construct(
            $cartRepository,
            $cartItemRepository,
            $cartAddressRepository,
            $productRepository,
            $taxCategoryRepository,
            $wishlistRepository,
            $customerAddressRepository
        );
    }

    /**
     * Return current logged in customer
     *
     * @return \Webkul\Customer\Contracts\Customer|bool
     */
    public function getCurrentCustomer()
    {
        $token = 0;
        if ( isset(getallheaders()['authorization'])) {
            $headerValue = explode("Bearer ", getallheaders()['authorization']);
            if ( isset($headerValue[1]) && $headerValue[1]) {
                $token = $headerValue[1];
            }
        }

        $guard = ($token || request()->has('token')) ? 'api' : 'customer';
        
        return auth()->guard($guard);
    }
}