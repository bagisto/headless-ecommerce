<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\CartRule\Repositories\CartRuleCouponRepository;
use Webkul\Checkout\Facades\Cart;
use Webkul\Core\Rules\PhoneNumber;
use Webkul\Customer\Repositories\CustomerAddressRepository;
use Webkul\GraphQLAPI\Repositories\NotificationRepository;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Payment\Facades\Payment;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Transformers\OrderResource;
use Webkul\Shipping\Facades\Shipping;

class CheckoutMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CartRuleCouponRepository $cartRuleCouponRepository,
        protected CustomerAddressRepository $customerAddressRepository,
        protected OrderRepository $orderRepository,
        protected NotificationRepository $notificationRepository
    ) {
        Auth::setDefaultDriver('api');
    }

    /**
     * Returns a customer's addresses detail.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function addresses(mixed $rootValue, array $args, GraphQLContext $context)
    {
        try {
            $customer = bagisto_graphql()->authorize();

            $formattedAddresses = [];

            foreach ($customer->addresses as $key => $address) {
                $formattedAddresses[$key] = [
                    'id'      => $address->id,
                    'address' => "{$customer->first_name} {$customer->last_name}, {$address->address}, {$address->city}, {$address->state}, {$address->country}, {$address->postcode}, T: {$address->phone}",
                ];
            }

            return [
                'is_guest'        => empty($customer),
                'customer'        => $customer,
                'addresses'       => $formattedAddresses,
                'default_country' => config('app.default_country') ?? 'IN',
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage and return shipping methods.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function saveCartAddresses(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $rules = [
            'type' => 'required',
        ];

        if (! empty($args['billing_address_id'])) {
            $rules = array_merge($rules, [
                'billing_address_id' => 'numeric|required',
            ]);
        } else {
            $rules = array_merge($rules, $this->mergeAddressRules('billing'));
        }

        if (empty($args['billing']['use_for_shipping'])) {
            if (! empty($args['shipping_address_id'])) {
                $rules = array_merge($rules, [
                    'shipping_address_id' => 'numeric|required',
                ]);
            } else {
                $rules = array_merge($rules, $this->mergeAddressRules('shipping'));
            }
        }

        bagisto_graphql()->validate($args, $rules);

        if (! $cart = Cart::getCart()) {
            throw new CustomException(trans('bagisto_graphql::app.shop.checkout.cart.item.fail.not-found'));
        }

        $billingAddressId = $args['billing_address_id'];

        $shippingAddressId = $args['shipping_address_id'];

        $token = request()->bearerToken();

        if (
            $token
            && ! auth()->check()
        ) {
            if (
                $billingAddressId
                || $shippingAddressId
            ) {
                throw new CustomException(trans('bagisto_graphql::app.shop.checkout.invalid-guest-user'));
            }

            throw new CustomException(trans('bagisto_graphql::app.shop.checkout.addresses.guest-address-warning'));
        }

        if (
            ! $token
            || (
                $token
                && auth()->check()
            )
        ) {
            if (
                ! auth()->check()
                && ! Cart::getCart()->hasGuestCheckoutItems()
            ) {
                throw new CustomException(trans('bagisto_graphql::app.shop.checkout.addresses.guest-checkout-warning'));
            }

            try {
                $data = [
                    'billing'   => [
                        'address'    => '',
                        'first_name' => $cart->customer_first_name,
                        'last_name'  => $cart->customer_last_name,
                        'email'      => $cart->customer_email,
                        'address_id' => $billingAddressId,
                    ],

                    'shipping'   => [
                        'address'    => '',
                        'first_name' => $cart->customer_first_name,
                        'last_name'  => $cart->customer_last_name,
                        'email'      => $cart->customer_email,
                        'address_id' => $shippingAddressId,
                    ],
                ];

                $addressFlag = false;

                if ($billingAddressId) {
                    $billingAddress = $this->customerAddressRepository->findOneWhere([
                        'id'           => $billingAddressId,
                        'address_type' => 'customer',
                    ]);

                    if (isset($billingAddress->id)) {
                        $data['billing'] = $this->getAddressData($billingAddress);

                        if (
                            isset($params['billing']['use_for_shipping'])
                            && $params['billing']['use_for_shipping'] == true
                        ) {
                            unset($data['shipping']['address_id']);

                            $data['billing']['use_for_shipping'] = true;
                        } else {
                            $data['billing']['use_for_shipping'] = false;
                        }
                    } else {
                        throw new CustomException(trans('bagisto_graphql::app.shop.checkout.addresses.no-billing-address-found'));
                    }
                } else {
                    $addressFlag = true;
                }

                if ($shippingAddressId) {
                    $shippingAddress = $this->customerAddressRepository->findOneWhere([
                        'id'           => $shippingAddressId,
                        'address_type' => 'customer',
                    ]);

                    if (isset($shippingAddress->id)) {
                        $data['shipping'] = $this->getAddressData($shippingAddress);
                    } else {
                        throw new CustomException(trans('bagisto_graphql::app.shop.checkout.addresses.no-shipping-address-found'));
                    }
                } else {
                    $addressFlag = true;
                }

                if ($addressFlag == true) {
                    if (
                        ! $billingAddressId
                        && isset($params['billing']['address'])
                    ) {
                        if (
                            isset($params['billing']['isSaved'])
                            && $params['billing']['isSaved'] == true
                        ) {
                            $this->customerAddressRepository->create(array_merge($params['billing'], [
                                'address' => implode(PHP_EOL, array_filter($params['billing']['address'])),
                            ]));
                        }

                        $data['billing'] = $params['billing'];

                        if (
                            isset($params['billing']['use_for_shipping'])
                            && $params['billing']['use_for_shipping'] == true
                        ) {
                            unset($data['shipping']['address_id']);
                        }
                    }

                    if (
                        ! $shippingAddressId
                        && isset($params['shipping']['address'])
                    ) {
                        if (
                            isset($params['shipping']['isSaved'])
                            && $params['shipping']['isSaved'] == true
                        ) {
                            $this->customerAddressRepository->create(array_merge($params['shipping'], [
                                'address' => implode(PHP_EOL, array_filter($params['shipping']['address'])),
                            ]));
                        }

                        if (empty($params['billing']['use_for_shipping'])) {
                            $data['shipping'] = $params['shipping'];
                        }
                    }

                    if (! empty($cart['is_guest'])) {
                        $data['billing']['customer_id'] = $data['shipping']['customer_id'] = null;
                    }
                }

                if (Cart::hasError()) {
                    throw new CustomException(current(Cart::getErrors()));
                }

                Cart::saveAddresses($data);

                Cart::collectTotals();

                if (
                    $cart->haveStockableItems()
                    && $args['type'] == 'shipping'
                ) {
                    if (! $rates = Shipping::collectRates()) {
                        throw new CustomException(trans('bagisto_graphql::app.shop.checkout.something-wrong'));
                    }

                    $shipping_methods = [];

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

                        $shipping_methods[] = [
                            'title'   => $shippingMethod['carrier_title'],
                            'methods' => $methods,
                        ];
                    }

                    return [
                        'message'          => trans('bagisto_graphql::app.shop.checkout.addresses.address-save-success'),
                        'cart'             => Cart::getCart(),
                        'shipping_methods' => $shipping_methods,
                        'jump_to_section'  => 'shipping',
                    ];
                }

                return [
                    'message'         => trans('bagisto_graphql::app.shop.checkout.addresses.address-save-success'),
                    'cart'            => Cart::getCart(),
                    'payment_methods' => Payment::getPaymentMethods(),
                    'jump_to_section' => 'payment',
                ];
            } catch (\Exception $e) {
                throw new CustomException($e->getMessage());
            }
        }
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
     * Get address data.
     *
     * @return array
     */
    private function getAddressData(object $address)
    {
        return [
            'company_name' => $address->company_name,
            'first_name'   => $address->first_name,
            'last_name'    => $address->last_name,
            'email'        => $address->email,
            'address'      => explode(PHP_EOL, $address->address),
            'city'         => $address->city,
            'country'      => $address->country,
            'state'        => $address->state,
            'postcode'     => $address->postcode,
            'phone'        => $address->phone,
        ];
    }

    /**
     * get shipping methods based on the cart address.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function shippingMethods(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $cart = Cart::getCart();

        if (! $cart) {
            throw new CustomException(trans('bagisto_graphql::app.shop.checkout.empty-cart'));
        }

        try {
            $token = request()->bearerToken();

            if (
                ! $token
                || (
                    $token
                    && auth()->check()
                )
            ) {
                if (
                    ! auth()->check()
                    && Cart::getCart()->hasGuestCheckoutItems()
                ) {
                    throw new CustomException(trans('bagisto_graphql::app.shop.checkout.invalid-guest-user'));
                }

                if (empty($cart->shipping_address->id)) {
                    throw new CustomException(trans('bagisto_graphql::app.shop.checkout.addresses.no-address-found'));
                }

                Cart::collectTotals();

                if ($cart->haveStockableItems()) {
                    if (! $rates = Shipping::collectRates()) {
                        throw new CustomException(trans('bagisto_graphql::app.shop.checkout.shipping.method-not-found'));
                    }

                    $shipping_methods = [];

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

                        $shipping_methods[] = [
                            'title'   => $shippingMethod['carrier_title'],
                            'methods' => $methods,
                        ];
                    }

                    return [
                        'message'          => trans('bagisto_graphql::app.shop.checkout.shipping.method-fetched'),
                        'cart'             => Cart::getCart(),
                        'shipping_methods' => $shipping_methods,
                        'jump_to_section'  => 'shipping',
                    ];
                } else {
                    return [
                        'message'         => trans('bagisto_graphql::app.shop.checkout.payment.method-fetched'),
                        'cart'            => Cart::getCart(),
                        'payment_methods' => Payment::getPaymentMethods(),
                        'jump_to_section' => 'payment',
                    ];
                }
            } elseif (
                $token
                && ! auth()->check()
            ) {
                throw new CustomException(trans('bagisto_graphql::app.shop.checkout.addresses.guest-address-warning'));
            }
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Save Payment Method
     *
     * @return array
     *
     * @throws CustomException
     */
    public function saveShipping(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'method' => 'required',
        ]);

        try {
            if (
                Cart::hasError()
                || ! Cart::saveShippingMethod($args['method'])
            ) {
                throw new CustomException(trans('bagisto_graphql::app.shop.checkout.shipping.save-failed'));
            }

            Cart::collectTotals();

            return [
                'message'         => trans('bagisto_graphql::app.shop.checkout.shipping.save-success'),
                'cart'            => Cart::getCart(),
                'jump_to_section' => 'payment',
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * get the available payment methods and save the shipping for the current cart.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function paymentMethods(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'shipping_method' => 'string|required',
        ]);

        try {
            if (
                Cart::hasError()
                || ! Cart::saveShippingMethod($args['shipping_method'])
            ) {
                throw new CustomException(trans('bagisto_graphql::app.shop.checkout.payment.method-not-found'));
            }

            Cart::collectTotals();

            return [
                'message'         => trans('bagisto_graphql::app.shop.checkout.payment.method-fetched'),
                'cart'            => Cart::getCart(),
                'payment_methods' => Payment::getPaymentMethods(),
                'jump_to_section' => 'payment',
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Save Payment Method
     *
     * @return array
     *
     * @throws CustomException
     */
    public function savePayment(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'method' => 'required',
        ]);

        try {
            if (
                Cart::hasError()
                || ! Cart::savePaymentMethod($args)
            ) {
                throw new CustomException(trans('bagisto_graphql::app.shop.checkout.payment.save-failed'));
            }

            Cart::collectTotals();

            return [
                'message'         => trans('bagisto_graphql::app.shop.checkout.payment.save-success'),
                'cart'            => Cart::getCart(),
                'jump_to_section' => 'review',
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Apply Coupon to cart
     *
     * @return array
     *
     * @throws CustomException
     */
    public function applyCoupon(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'code' => 'string|required',
        ]);

        try {
            if (strlen($args['code'])) {
                $coupon = $this->cartRuleCouponRepository->findOneByField('code', $args['code']);

                if (! $coupon) {
                    return [
                        'success' => false,
                        'message' => trans('bagisto_graphql::app.shop.checkout.coupon.invalid-code'),
                        'cart'    => Cart::getCart(),
                    ];
                }

                if ($coupon->cart_rule->status) {
                    if (Cart::getCart()->coupon_code == $args['code']) {
                        return [
                            'success' => true,
                            'message' => trans('bagisto_graphql::app.shop.checkout.coupon.already-applied'),
                            'cart'    => Cart::getCart(),
                        ];
                    }

                    Cart::setCouponCode($args['code'])->collectTotals();

                    if (Cart::getCart()->coupon_code == $args['code']) {
                        return [
                            'success' => true,
                            'message' => trans('bagisto_graphql::app.shop.checkout.coupon.apply-success'),
                            'cart'    => Cart::getCart(),
                        ];
                    }
                }
            }

            return [
                'success' => false,
                'message' => trans('bagisto_graphql::app.shop.checkout.coupon.invalid-code'),
                'cart'    => Cart::getCart(),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Remove Coupon from cart
     *
     * @return array
     *
     * @throws CustomException
     */
    public function removeCoupon(mixed $rootValue, array $args, GraphQLContext $context)
    {
        try {
            if (Cart::getCart()->coupon_code) {
                Cart::removeCouponCode()->collectTotals();

                return [
                    'success' => true,
                    'message' => trans('bagisto_graphql::app.shop.checkout.coupon.remove-success'),
                    'cart'    => Cart::getCart(),
                ];
            }

            return [
                'success' => false,
                'message' => trans('bagisto_graphql::app.shop.checkout.couponremove-failed'),
                'cart'    => Cart::getCart(),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Save Order
     *
     * @return array
     *
     * @throws CustomException
     */
    public function saveOrder(mixed $rootValue, array $args, GraphQLContext $context)
    {
        try {
            if (Cart::hasError()) {
                throw new CustomException(trans('bagisto_graphql::app.shop.checkout.error-placing-order'));
            }

            Cart::collectTotals();

            $this->validateOrder();

            $cart = Cart::getCart();

            if ($redirectUrl = Payment::getRedirectUrl($cart)) {
                return [
                    'success'         => true,
                    'redirect_url'    => $redirectUrl,
                    'selected_method' => $cart->payment->method,
                ];
            }

            $data = (new OrderResource($cart))->jsonSerialize();

            $order = $this->orderRepository->create($data);

            if (core()->getConfigData('general.api.pushnotification.private_key')) {
                $this->prepareNotificationContent($order);
            }

            Cart::deActivateCart();

            return [
                'success'      => true,
                'redirect_url' => null,
                'order'        => $order,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Validate order before creation
     *
     * @return void|CustomException
     */
    public function validateOrder()
    {
        $cart = Cart::getCart();

        if (
            $cart->haveStockableItems()
            && ! $cart->shipping_address
        ) {
            throw new CustomException(trans('bagisto_graphql::app.shop.checkout.missing-shipping-address'));
        }

        if (! $cart->billing_address) {
            throw new CustomException(trans('bagisto_graphql::app.shop.checkout.missing-billing-address'));
        }

        if (
            $cart->haveStockableItems()
            && ! $cart->selected_shipping_rate
        ) {
            throw new CustomException(trans('bagisto_graphql::app.shop.checkout.missing-shipping-method'));
        }

        if (! $cart->payment) {
            throw new CustomException(trans('bagisto_graphql::app.shop.checkout.missing-payment-method'));
        }
    }

    /**
     * Prepare data for order push notification.
     *
     * @param  \Webkul\Sales\Contracts\Order  $order
     * @return mixed
     */
    public function prepareNotificationContent($order)
    {
        $data = [
            'title'       => 'New Order Placed',
            'body'        => 'Order ('.$order->id.') placed by '.$order->customerFullName.' successfully.',
            'message'     => 'Order ('.$order->id.') placed by '.$order->customerFullName.' successfully.',
            'sound'       => 'default',
            'orderStatus' => $order->parcel_status,
            'orderId'     => (string) $order->id,
            'type'        => 'order',
        ];

        $notification = [
            'title'   => $data['title'],
            'content' => $data['body'],
        ];

        $this->notificationRepository->sendNotification($data, $notification);
    }
}
