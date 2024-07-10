<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Exception;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Http\Controllers\Controller;
use Webkul\CartRule\Repositories\CartRuleCouponRepository;
use Webkul\Checkout\Facades\Cart;
use Webkul\Core\Rules\AlphaNumericSpace;
use Webkul\Core\Rules\PhoneNumber;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Customer\Repositories\CustomerAddressRepository;
use Webkul\Payment\Facades\Payment;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Shipping\Facades\Shipping;
use Webkul\GraphQLAPI\Validators\Customer\CustomException;
use Webkul\GraphQLAPI\Repositories\NotificationRepository;

class CheckoutMutation extends Controller
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
     * @param  \Webkul\Customer\Repositories\CartRuleCouponRepository  $cartRuleCouponRepository
     * @param  \Webkul\Customer\Repositories\CustomerRepository  $customerRepository
     * @param  \Webkul\Customer\Repositories\CustomerAddressRepository  $customerAddressRepository
     * @param  \Webkul\Sales\Repositories\OrderRepository  $orderRepository
     * @param  \Webkul\GraphQLAPI\Repositories\NotificationRepository  $notificationRepository
     * @return void
     */
    public function __construct(
        protected CartRuleCouponRepository $cartRuleCouponRepository,
        protected CustomerRepository $customerRepository,
        protected CustomerAddressRepository $customerAddressRepository,
        protected OrderRepository $orderRepository,
        protected NotificationRepository $notificationRepository
    )
    {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);

        $this->middleware('auth:'.$this->guard);
    }

    /**
     * Returns a customer's addresses detail.
     *
     * @return \Illuminate\Http\Response
     */
    public function addresses($rootValue, array $args , GraphQLContext $context)
    {
        $token = request()->bearerToken();

        try {
            $validateUser = bagisto_graphql()->apiAuth($token, $this->guard);

            $customer = [];

            $customerAddresses = [];

            $formattedAddresses = [];

            if (
                ! $token
                || ! empty($validateUser['success'])
             ) {

                if (bagisto_graphql()->guard($this->guard)->check()) {
                    $customer = bagisto_graphql()->guard($this->guard)->user();

                    $customerAddresses = $customer->addresses()->get();

                    foreach ($customerAddresses as $key => $address) {

                        $formattedAddresses[$key] = [
                            'id'        => $address->id,
                            'address'   => "{$customer->first_name} {$customer->last_name}
                            {$address->address1}, {$address->city}, {$address->state}, {$address->country},
                            {$address->postcode}
                            T: {$address->phone}",
                        ];
                    }
                }
            }

            return [
                'success'         => $customer ? trans('bagisto_graphql::app.shop.customer.success-address-list') : trans('bagisto_graphql::app.shop.customer.no-address-list'),
                'is_guest'        => (isset($customer->id)) ? 0 : 1,
                'customer'        => $customer,
                'addresses'       => $formattedAddresses,
                'address_list'    => $customerAddresses,
                'cart'            => Cart::getCart(),
                'default_country' => config('app.default_country') ?? 'IN',
            ];
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                'Error in fetching addresses.'
            );
        }
    }

    /**
     * Store a newly created resource in storage and return shipping methods.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCartAddresses($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['input'])) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.checkout.error-invalid-parameter'),
                trans('bagisto_graphql::app.shop.checkout.error-invalid-parameter')
            );
        }

        $params = $args['input'];

        $rules = ['type' => 'required'];

        if (! empty($params['billing_address_id'])) {
            $rules = array_merge($rules, [
                'billing_address_id' => 'numeric|required',
            ]);
        } else {
            $rules = array_merge($rules, [
                "billing.first_name" => 'required',
                "billing.last_name"  => 'required',
                "billing.email"      => 'required',
                "billing.address1"   => 'required',
                "billing.city"       => 'required',
                "billing.country"    => 'required',
                "billing.state"      => 'required',
                "billing.postcode"   => 'numeric',
                "billing.phone"      => 'required',
            ]);
        }

        if (empty($params['billing']['use_for_shipping'])) {
            if (! empty($params['shipping_address_id'])) {
                $rules = array_merge($rules, [
                    'shipping_address_id' => 'numeric|required',
                ]);
            } else {
                $rules = array_merge($rules, [
                    "shipping.first_name" => ['required', new AlphaNumericSpace],
                    "shipping.last_name"  => ['required', new AlphaNumericSpace],
                    "shipping.email"      => ['required'],
                    "shipping.address1"   => ['required'],
                    "shipping.city"       => ['required'],
                    "shipping.country"    => [new AlphaNumericSpace],
                    "shipping.state"      => [new AlphaNumericSpace],
                    "shipping.postcode"   => ['numeric'],
                    "shipping.phone"      => ['required', new PhoneNumber],
                ]);
            }
        }

        $validator = Validator::make($params, $rules);

        if ($validator->fails()) {
            $errorMessage = [];

            foreach ($validator->messages()->toArray() as $field => $message) {
                $errorMessage[] = is_array($message) ? $field .': '. $message[0] : $field .': '. $message;
            }

            throw new CustomException(
                implode(", ", $errorMessage),
                'Invalid Create Shipping/Billing Address Details.'
            );
        }

        $cart = Cart::getCart();

        if (! $cart) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.checkout.warning-empty-cart'),
                trans('bagisto_graphql::app.shop.checkout.warning-empty-cart')
            );
        }

        $billingAddressId = $params['billing_address_id'];

        $shippingAddressId = $params['shipping_address_id'];

        if (
            ! $billingAddressId
            && empty($params['billing'])
        ) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.checkout.billing-address-missing'),
                'Billing address missing.'
            );
        }

        if (
            ! $shippingAddressId
            && empty($params['billing']['use_for_shipping'])
            && (
                ! isset($params['shipping'])
                || empty($params['shipping'])
            )
        ) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.checkout.shipping-address-missing'),
                'Shipping address missing.'
            );
        }

        $token = 0;

        if (isset(getallheaders()['Authorization'])) {
            $headerValue = explode("Bearer ", getallheaders()['Authorization']);

            if (! empty($headerValue[1])) {
                $token = $headerValue[1];
            }
        }

        $validateUser = bagisto_graphql()->apiAuth($token, $this->guard);

        if (
            $token
            && empty($validateUser['success'])
        ) {
            if ($billingAddressId || $shippingAddressId) {
                throw new CustomException(
                    trans('bagisto_graphql::app.shop.checkout.invalid-guest-access'),
                    trans('bagisto_graphql::app.shop.checkout.invalid-guest-access')
                );
            }

            throw new CustomException(
                trans('bagisto_graphql::app.shop.checkout.guest-address-warning'),
                trans('bagisto_graphql::app.shop.checkout.guest-address-warning')
            );
        }

        if (
            ! $token
            || (
                $token
                && ! empty($validateUser['success'])
            )
        ) {
            if (
                ! bagisto_graphql()->guard($this->guard)->check()
                && ! Cart::getCart()->hasGuestCheckoutItems()
            ) {
                throw new CustomException(
                    'Cart have some item(s), which are not allowed for guest checkout.',
                    trans('bagisto_graphql::app.shop.checkout.wrong-error')
                );
            }

            try {
                $data = [
                    'billing'   => [
                        'address1'   => '',
                        'first_name' => $cart->customer_first_name,
                        'last_name'  => $cart->customer_last_name,
                        'email'      => $cart->customer_email,
                        'address_id' => $billingAddressId,
                    ],

                    'shipping'   => [
                        'address1'   => '',
                        'first_name' => $cart->customer_first_name,
                        'last_name'  => $cart->customer_last_name,
                        'email'      => $cart->customer_email,
                        'address_id' => $shippingAddressId,
                    ],
                ];
                $address_flag = false;

                if ($billingAddressId) {
                    $billingAddress = $this->customerAddressRepository->findOneWhere([
                        'id'           => $billingAddressId,
                        'address_type' => 'customer',
                    ]);

                    if (isset($billingAddress->id)) {
                        $data['billing']['first_name'] = $billingAddress->first_name;

                        $data['billing']['last_name'] = $billingAddress->last_name;

                        $data['billing']['address1'] = $billingAddress->address1;

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
                        throw new CustomException(
                            trans('bagisto_graphql::app.shop.checkout.no-billing-address-found', ['address_id' => $billingAddressId]),
                            'No billing address found.'
                        );
                    }
                } else {
                    $address_flag = true;
                }

                if ($shippingAddressId) {
                    $shippingAddress = $this->customerAddressRepository->findOneWhere([
                        'id'           => $shippingAddressId,
                        'address_type' => 'customer'
                    ]);

                    if (isset($shippingAddress->id)) {
                        $data['shipping']['address1'] = $shippingAddress->address1;
                    } else {
                        throw new CustomException(
                            trans('bagisto_graphql::app.shop.checkout.no-shipping-address-found', ['address_id' => $shippingAddressId]),
                            'No shipping address found.'
                        );
                    }
                } else {
                    $address_flag = true;
                }

                if ($address_flag == true) {
                    if (
                        ! $billingAddressId
                        && isset($params['billing']['address1'])
                    ) {
                        if (
                            isset($params['billing']['isSaved'])
                            && $params['billing']['isSaved'] == true
                        ) {
                            $this->customerAddressRepository->create($params['billing']);
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
                        && isset($params['shipping']['address1'])
                    ) {
                        if (
                            isset($params['shipping']['isSaved'])
                            && $params['shipping']['isSaved'] == true
                        ) {
                            $this->customerAddressRepository->create($params['shipping']);
                        }

                        if (empty($params['billing']['use_for_shipping'])) {
                            $data['shipping'] = $params['shipping'];
                        }
                    }

                    if (! empty($cart['is_guest'])) {
                        $data['billing']['customer_id'] = $data['shipping']['customer_id'] = null;
                    }
                }

                if (
                    Cart::hasError()
                    || ! Cart::saveCustomerAddress($data)
                ) {
                    throw new CustomException(
                        trans('bagisto_graphql::app.shop.checkout.wrong-error'),
                        'Cart have some item(s), which are not allowed for guest checkout.'
                    );
                }

                Cart::collectTotals();

                if (
                    $cart->haveStockableItems()
                    && $params['type'] == 'shipping'
                ) {
                    if (! $rates = Shipping::collectRates()) {
                        throw new CustomException(
                            trans('bagisto_graphql::app.shop.checkout.wrong-error'),
                            'Error in fatching shipping rate.'
                        );
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
                                'formatted_base_price' => core()->formatBasePrice($rate->base_price)
                            ];
                        }
                        $shipping_methods[] = [
                            'title'   => $shippingMethod['carrier_title'],
                            'methods' => $methods,
                        ];
                    }

                    return [
                        'success'          => trans('bagisto_graphql::app.shop.checkout.save-cart-address'),
                        'cart'             => Cart::getCart(),
                        'shipping_methods' => $shipping_methods,
                        'jump_to_section'  => 'shipping',
                    ];
                }

                return [
                    'success'         => trans('bagisto_graphql::app.shop.checkout.save-cart-address'),
                    'cart'            => Cart::getCart(),
                    'payment_methods' => Payment::getPaymentMethods(),
                    'jump_to_section' => 'payment',
                ];
            } catch (Exception $e) {
                throw new CustomException(
                    $e->getMessage(),
                    'Error in saving shipping/billing address.'
                );
            }
        }
    }

    /**
     * get shipping methods based on the cart address.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function shippingMethods($rootValue, array $args, GraphQLContext $context)
    {
        $cart = Cart::getCart();

        if (! $cart) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.checkout.warning-empty-cart'),
                'Your cart is empty.'
            );
        }

        try {
            $token = request()->bearerToken();

            $validateUser = bagisto_graphql()->apiAuth($token, $this->guard);

            if (
                ! $token
                || (
                    $token
                    && ! empty($validateUser['success'])
                )
            ) {
                if (
                    ! bagisto_graphql()->guard($this->guard)->check()
                    && ! Cart::getCart()->hasGuestCheckoutItems()
                ) {
                    throw new CustomException(
                        trans('bagisto_graphql::app.shop.checkout.wrong-error'),
                        'Cart have some item(s), which are not allowed for guest checkout.'
                    );
                }

                if (! isset($cart->shipping_address->id)) {
                    throw new CustomException(
                        'Error: No shipping/billing address found for the current cart.',
                        'Error in fetching shipping/billing address.'
                    );
                }

                Cart::collectTotals();

                if ($cart->haveStockableItems()) {
                    if (! $rates = Shipping::collectRates()) {
                        throw new CustomException(
                            trans('bagisto_graphql::app.shop.checkout.wrong-error'),
                            'Error in fatching shipping rate.'
                        );
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
                        'success'          => 'Success: Shipping Methods fetched successfully',
                        'cart'             => Cart::getCart(),
                        'shipping_methods' => $shipping_methods,
                        'jump_to_section'  => 'shipping',
                    ];
                }

                return [
                    'success'         => trans('bagisto_graphql::app.shop.checkout.save-cart-address'),
                    'cart'            => Cart::getCart(),
                    'payment_methods' => Payment::getPaymentMethods(),
                    'jump_to_section' => 'payment',
                ];
            } elseif (
                    $token
                    && empty($validateUser['success'])
                ) {
                    throw new CustomException(
                        trans('bagisto_graphql::app.shop.checkout.guest-address-warning'),
                        'guest-address-warning.'
                    );
            }
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                'Error in saving shipping/billing address.'
            );
        }
    }

    /**
     * get the available payment methods and save the shipping for the current cart.
     *
     * @param  array  $args
     * @return \Illuminate\Http\Response
     */
    public function paymentMethods($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['input'])) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.checkout.error-invalid-parameter'),
                'Invalid request parameters.'
            );
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'shipping_method' => 'string|required',
        ]);

        if ($validator->fails()) {
            $errorMessage = [];

            foreach ($validator->messages()->toArray() as $message) {
                $errorMessage[] = is_array($message) ? $message[0] : $message;
            }

            throw new CustomException(
                implode(" ,", $errorMessage),
                'Invalid choosing shipping method.'
            );
        }

        try {
            if (
                Cart::hasError()
                || ! Cart::saveShippingMethod($data['shipping_method'])
            ) {
                throw new CustomException(
                    trans('bagisto_graphql::app.shop.checkout.error-payment-selection'),
                    'Error in saving shipping method.'
                );
            }

            Cart::collectTotals();

            return [
                'success'         => trans('bagisto_graphql::app.shop.checkout.selected-shipment'),
                'cart'            => Cart::getCart(),
                'payment_methods' => Payment::getPaymentMethods(),
                'jump_to_section' => 'payment',
            ];
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                'Error in saving shipping method.'
            );
        }
    }

    /**
     * Save Payment Method
     *
     * @param  array  $args
     * @return \Illuminate\Http\Response
     */
    public function savePayment($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['input'])) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.checkout.error-invalid-parameter'),
                'Invalid request parameters.'
            );
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'method' => 'required',
        ]);

        if ($validator->fails()) {
            $errorMessage = [];

            foreach ($validator->messages()->toArray() as $message) {
                $errorMessage[] = is_array($message) ? $message[0] : $message;
            }

            throw new CustomException(
                implode(" ,", $errorMessage),
                'Invalid choosing shipping method.'
            );
        }

        try {
            if (
                Cart::hasError()
                || ! Cart::savePaymentMethod($data)
            ) {
                throw new CustomException(
                    trans('bagisto_graphql::app.shop.checkout.error-payment-save'),
                    'Error in saving payment method.'
                );
            }

            Cart::collectTotals();

            return [
                'success'         => trans('bagisto_graphql::app.shop.checkout.selected-payment'),
                'cart'            => Cart::getCart(),
                'jump_to_section' => 'review',
            ];
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                'Error in saving payment method.'
            );
        }
    }

    /**
     * Apply Coupon to cart
     *
     * @return \Illuminate\Http\Response
     */
    public function applyCoupon($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['input'])) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.checkout.error-invalid-parameter'),
                trans('bagisto_graphql::app.shop.checkout.error-invalid-parameter')
            );
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'code' => 'string|required',
        ]);

        if ($validator->fails()) {
            throw new CustomException(
                $validator->messages(),
                $validator->messages()
            );
        }

        try {
            if (strlen($data['code'])) {
                $coupon = $this->cartRuleCouponRepository->findOneByField('code', $data['code']);

                if (! $coupon) {
                    return [
                        'success' => false,
                        'message' => trans('Coupon not found.'),
                        'cart'    => Cart::getCart(),
                    ];
                }

                if ($coupon->cart_rule->status) {
                    if (Cart::getCart()->coupon_code == $data['code']) {
                        return [
                            'success' => true,
                            'message' => trans('bagisto_graphql::app.shop.checkout.already-applied'),
                            'cart'    => Cart::getCart(),
                        ];
                    }

                    Cart::setCouponCode($data['code'])->collectTotals();

                    if (Cart::getCart()->coupon_code == $data['code']) {
                        return [
                            'success' => true,
                            'message' => trans('bagisto_graphql::app.shop.checkout.success-apply'),
                            'cart'    => Cart::getCart(),
                        ];
                    }
                }
            }

            return [
                'success' => false,
                'message' => trans('bagisto_graphql::app.shop.checkout.invalid-coupon'),
                'cart'    => Cart::getCart(),
            ];
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                $e->getMessage()
            );
        }
    }

    /**
     * Remove Coupon from cart
     *
     * @return \Illuminate\Http\Response
     */
    public function removeCoupon($rootValue, array $args, GraphQLContext $context)
    {
        try {
            if (Cart::getCart()->coupon_code) {
                Cart::removeCouponCode()->collectTotals();

                return [
                    'success' => true,
                    'message' => trans('bagisto_graphql::app.shop.checkout.coupon-removed'),
                    'cart'    => Cart::getCart(),
                ];
            }

            return [
                'success' => false,
                'message' => trans('bagisto_graphql::app.shop.checkout.coupon-remove-failed'),
                'cart'    => Cart::getCart(),
            ];
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                $e->getMessage()
            );
        }
    }

    /**
     * Create order
     *
     * @return \Illuminate\Http\Response
     */
    public function saveOrder($rootValue, array $args, GraphQLContext $context)
    {
        try {
            if (Cart::hasError()) {
                throw new CustomException(
                    trans('bagisto_graphql::app.shop.checkout.error-placing-order'),
                    'Some error found in cart.'
                );
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

            $order = $this->orderRepository->create(Cart::prepareDataForOrder());

            $this->prepareNotificationContent($order);

            Cart::deActivateCart();

            return [
                'success'      => true,
                'redirect_url' => null,
                'order'        => $order,
            ];
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                'Error found in order processing.'
            );
        }
    }

    /**
     * Validate order before creation
     *
     * @return void|Exception
     */
    public function validateOrder()
    {
        $cart = Cart::getCart();

        if ($cart->haveStockableItems() && ! $cart->shipping_address) {
            throw new Exception(trans('Please check shipping address.'));
        }

        if (! $cart->billing_address) {
            throw new Exception(trans('Please check billing address.'));
        }

        if ($cart->haveStockableItems() && ! $cart->selected_shipping_rate) {
            throw new Exception(trans('Please specify shipping method.'));
        }

        if (! $cart->payment) {
            throw new Exception(trans('Please specify payment method.'));
        }
    }

    /**
     * Prepare data for order push notification.
     *
     * @param  \Webkul\Sales\Contracts\Order  $order
     * @return Response
     */
    public function prepareNotificationContent($order)
    {
        $data = [
            'title'       => 'New Order Placed',
            'body'        => 'Order ('.$order->id.') placed by '. $order->customerFullName .' successfully.',
            'message'     => 'Order ('.$order->id.') placed by '. $order->customerFullName .' successfully.',
            'sound'       => 'default',
            'orderStatus' => $order->parcel_status,
            'orderId'     => (string)$order->id,
            'type'        => 'order',
        ];

        $notification   = [
            'title'   => $data['title'],
            'content' => $data['body'],
        ];

        $this->notificationRepository->sendNotification($data, $notification);
    }
}
