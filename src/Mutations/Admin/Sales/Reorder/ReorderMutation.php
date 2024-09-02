<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Sales\Reorder;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Repositories\CartItemRepository;
use Webkul\Checkout\Repositories\CartRepository;
use Webkul\Core\Rules\PhoneNumber;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Payment\Facades\Payment;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Transformers\OrderResource;
use Webkul\Shipping\Facades\Shipping;

class ReorderMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CartRepository $cartRepository,
        protected CartItemRepository $cartItemRepository,
        protected CustomerRepository $customerRepository,
        protected ProductRepository $productRepository,
        protected OrderRepository $orderRepository
    ) {}

    /**
     * Create cart
     *
     * @return array
     *
     * @throws CustomException
     */
    public function createCart(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $customer = $this->customerRepository->find($args['customer_id']);

        try {
            $cart = Cart::createCart([
                'customer'  => $customer,
                'is_active' => false,
            ]);

            $cart->refresh();

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.sales.reorder.cart-create-success'),
                'cart'    => $cart,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Add items to cart.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function addCartItem(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'cart_id'    => 'required|integer|exists:cart,id',
            'product_id' => 'required|integer|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $cart = $this->cartRepository->find($args['cart_id']);

        if (! $cart) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.reorder.cart-not-found'));
        }

        Cart::setCart($cart);

        try {
            $product = $this->productRepository->find($args['product_id']);

            Cart::addProduct($product, $args);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.sales.reorder.cart-item-add-success'),
                'cart'    => Cart::getCart(),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Remove item from cart.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function deleteCartItem(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $cartItem = $this->cartItemRepository->find($args['id']);

        if (! $cartItem) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.reorder.cart-item-not-found'));
        }

        Cart::setCart($cartItem->cart);

        Cart::removeItem($args['id']);

        Cart::collectTotals();

        return [
            'success' => true,
            'message' => trans('bagisto_graphql::app.admin.sales.reorder.cart-item-remove-success'),
            'cart'    => Cart::getCart(),
        ];
    }

    /**
     * Updates the cart item quantity.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function updateCartItem(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'cart_item_id' => 'required|integer|exists:cart_items,id',
            'quantity'     => 'required|integer|min:1',
        ]);

        $cartItem = $this->cartItemRepository->find($args['cart_item_id']);

        if (! $cartItem) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.reorder.cart-item-not-found'));
        }

        Cart::setCart($cartItem->cart);

        try {
            $args['qty'] = [$args['cart_item_id'] => $args['quantity']];

            Cart::updateItems($args);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.sales.reorder.cart-item-update-success'),
                'cart'    => Cart::getCart(),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Store address.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function storeAddress(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $cart = $this->cartRepository->find($args['id']);

        if (! $cart) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.reorder.cart-not-found'));
        }

        $rules = [];

        $rules = array_merge($rules, $this->mergeAddressRules('billing'));

        if (empty($args['billing']['use_for_shipping'])) {
            $rules = array_merge($rules, $this->mergeAddressRules('shipping'));
        }

        bagisto_graphql()->validate($args, $rules);

        Cart::setCart($cart);

        if (Cart::hasError()) {
            throw new CustomException(current(Cart::getErrors()));
        }

        Cart::saveAddresses($args);

        Cart::collectTotals();

        if ($cart->haveStockableItems()) {
            if (! $rates = Shipping::collectRates()) {
                throw new CustomException(trans('bagisto_graphql::app.admin.sales.reorder.something-wrong'));
            }

            $shippingMethods = [];

            foreach ($rates['shippingMethods'] as $shippingMethod) {
                $methods = [];

                foreach ($shippingMethod['rates'] as $rate) {
                    $methods = [
                        'code'                 => $rate->method,
                        'label'                => $rate->method_title,
                        'price'                => $rate->price,
                        'formatted_price'      => core()->formatPrice($rate->price),
                        'base_price'           => $rate->base_price,
                        'formatted_base_price' => core()->formatBasePrice($rate->base_price),
                    ];
                }

                $shippingMethods[] = [
                    'title'   => $shippingMethod['carrier_title'],
                    'methods' => $methods,
                ];
            }

            return [
                'message'          => trans('bagisto_graphql::app.admin.sales.reorder.address-save-success'),
                'cart'             => Cart::getCart(),
                'shipping_methods' => $shippingMethods,
                'jump_to_section'  => 'shipping',
            ];
        }

        return [
            'message'         => trans('bagisto_graphql::app.admin.sales.reorder.address-save-success'),
            'cart'            => Cart::getCart(),
            'payment_methods' => Payment::getPaymentMethods(),
            'jump_to_section' => 'payment',
        ];
    }

    /**
     * Store shipping method.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function storeShippingMethod(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'shipping_method' => 'required',
        ]);

        $cart = $this->cartRepository->find($args['id']);

        if (! $cart) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.reorder.cart-not-found'));
        }

        Cart::setCart($cart);

        if (
            Cart::hasError()
            || ! $args['shipping_method']
            || ! Cart::saveShippingMethod($args['shipping_method'])
        ) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.reorder.something-wrong'));
        }

        Cart::collectTotals();

        return [
            'message'         => trans('bagisto_graphql::app.admin.sales.reorder.shipping-save-success'),
            'cart'            => Cart::getCart(),
            'payment_methods' => Payment::getPaymentMethods(),
            'jump_to_section' => 'payment',
        ];
    }

    /**
     * Store payment method.
     *
     * @return array
     */
    public function storePaymentMethod(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'method' => 'required',
        ]);

        $cart = $this->cartRepository->find($args['id']);

        if (! $cart) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.reorder.cart-not-found'));
        }

        Cart::setCart($cart);

        if (
            Cart::hasError()
            || ! $args['method']
            || ! Cart::savePaymentMethod($args)
        ) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.reorder.something-wrong'));
        }

        Cart::collectTotals();

        return [
            'message'         => trans('bagisto_graphql::app.admin.sales.reorder.payment-save-success'),
            'cart'            => Cart::getCart(),
            'jump_to_section' => 'review',
        ];
    }

    /**
     * Store order.
     *
     * @return array
     */
    public function storeOrder(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $cart = $this->cartRepository->find($args['id']);

        if (! $cart) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.reorder.cart-not-found'));
        }

        Cart::setCart($cart);

        if (Cart::hasError()) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.reorder.something-wrong'));
        }

        Cart::collectTotals();

        try {
            $this->validateOrder();
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }

        $cart = Cart::getCart();

        if (Payment::getRedirectUrl($cart)) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.reorder.payment-method-not-found'));
        }

        $data = (new OrderResource($cart))->jsonSerialize();

        $order = $this->orderRepository->create($data);

        Cart::removeCart($cart);

        return [
            'success' => true,
            'message' => trans('bagisto_graphql::app.admin.sales.reorder.order-placed-success'),
            'order'   => $order,
        ];
    }

    /**
     * Merge new address rules.
     */
    private function mergeAddressRules(string $addressType): array
    {
        return [
            "{$addressType}.company_name" => ['nullable'],
            "{$addressType}.first_name"   => ['required'],
            "{$addressType}.last_name"    => ['required'],
            "{$addressType}.email"        => ['required'],
            "{$addressType}.address"      => ['required', 'array', 'min:1'],
            "{$addressType}.city"         => ['required'],
            "{$addressType}.country"      => ['required'],
            "{$addressType}.state"        => ['required'],
            "{$addressType}.postcode"     => ['required', 'numeric'],
            "{$addressType}.phone"        => ['required', new PhoneNumber],
        ];
    }

    /**
     * Validate order before creation.
     *
     * @return void|CustomException
     */
    public function validateOrder()
    {
        $cart = Cart::getCart();

        if (! Cart::haveMinimumOrderAmount()) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.reorder.minimum-order-amount-err', [
                'amount' => core()->formatPrice(core()->getConfigData('sales.order_settings.minimum_order.minimum_order_amount') ?: 0),
            ]));
        }

        if (
            $cart->haveStockableItems()
            && ! $cart->shipping_address
        ) {
            throw new \Exception(trans('bagisto_graphql::app.admin.sales.reorder.check-shipping-address'));
        }

        if (! $cart->billing_address) {
            throw new \Exception(trans('bagisto_graphql::app.admin.sales.reorder.check-billing-address'));
        }

        if (
            $cart->haveStockableItems()
            && ! $cart->selected_shipping_rate
        ) {
            throw new \Exception(trans('bagisto_graphql::app.admin.sales.reorder.specify-shipping-method'));
        }

        if (! $cart->payment) {
            throw new \Exception(trans('bagisto_graphql::app.admin.sales.reorder.specify-payment-method'));
        }
    }
}