<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Exception;
use Webkul\GraphQLAPI\Validators\Customer\CustomException;
use Webkul\Checkout\Facades\Cart;
use Webkul\Customer\Http\Controllers\Controller;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\Customer\Repositories\CustomerAddressRepository;
use Webkul\Shipping\Facades\Shipping;
use Webkul\Payment\Facades\Payment;
use Webkul\Sales\Repositories\OrderRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CheckoutMutation extends Controller
{
    /**
     * Contains current guard
     *
     * @var array
     */
    protected $guard;

    /**
     * CustomerRepository object
     *
     * @var \Webkul\Customer\Repositories\CustomerRepository;
     */
    protected $customerRepository;

    /**
     * CustomerAddressRepository object
     *
     * @var \Webkul\Customer\Repositories\CustomerAddressRepository;
     */
    protected $customerAddressRepository;

    /**
     * OrderRepository object
     *
     * @var \Webkul\Sales\Repositories\OrderRepository;
     */
    protected $orderRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Customer\Repositories\CustomerRepository  $customerRepository
     * @param  \Webkul\Customer\Repositories\CustomerAddressRepository  $customerAddressRepository
     * @param  \Webkul\Sales\Repositories\OrderRepository  $orderRepository
     * @return void
     */
    public function __construct(
        CustomerRepository $customerRepository,
        CustomerAddressRepository $customerAddressRepository,
        OrderRepository $orderRepository
    )
    {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);
        
        $this->middleware('auth:' . $this->guard);
        
        $this->customerRepository = $customerRepository;
        
        $this->customerAddressRepository = $customerAddressRepository;
        
        $this->orderRepository = $orderRepository;
    }

    /**
     * Returns a customer's addresses detail.
     *
     * @return \Illuminate\Http\Response
     */
    public function addresses($rootValue, array $args , GraphQLContext $context)
    {
        $token = 0;
        if ( isset(getallheaders()['authorization'])) {
            $headerValue = explode("Bearer ", getallheaders()['authorization']);
            if ( isset($headerValue[1]) && $headerValue[1]) {
                $token = $headerValue[1];
            }
        }
        
        try {
            $validateUser = bagisto_graphql()->apiAuth($token, $this->guard);
            
            $customer = [];
            $customerAddresses = [];
            $formatted_addresses = [];

            if (! $token || ($token && isset($validateUser['success']) && $validateUser['success']) ) {

                if ( bagisto_graphql()->guard($this->guard)->check() ) {
                    $customer = bagisto_graphql()->guard($this->guard)->user();
                    $customerAddresses = $customer->addresses()->get();
                    
                    foreach ($customerAddresses as $key => $address) {
                        
                        $formatted_addresses[$key] = [
                            'id'        => $address->id,
                            'address'   => "{$customer->first_name} {$customer->last_name}
                            {$address->address1}, {$address->city}, {$address->state}, {$address->country}, 
                            {$address->postcode}
                            T: {$address->phone}",
                        ];
                    }
                }
            }

            $cart = Cart::getCart();

            return [
                'success'           => $customer ? trans('bagisto_graphql::app.shop.customer.success-address-list') : trans('bagisto_graphql::app.shop.customer.no-address-list'),
                'is_guest'          => (isset($customer->id)) ? 0 : 1,
                'customer'          => $customer,
                'addresses'         => $formatted_addresses,
                'address_list'      => $customerAddresses,
                'cart_count'        => $cart ? count($cart->items) : 0,
                'default_country'   => config('app.default_country') ? config('app.default_country') : 'IN'
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
        if (! isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new CustomException(
                trans('bagisto_graphql::app.admin.response.error-invalid-parameter'),
                'Invalid request parameters.'
            );
        }

        $params = $args['input'];
       
        $validator = \Validator::make($params, [
            'billing_address_id'    => 'numeric|required',
            'shipping_address_id'   => 'numeric|required',
            'type'                  => 'required',
        ]);
        
        if ($validator->fails()) {
            $errorMessage = [];
            foreach ($validator->messages()->toArray() as $field => $message) {
                $errorMessage[] = is_array($message) ? $message[0] : $message;
            }
            
            throw new CustomException(
                implode(" ,", $errorMessage),
                'Invalid Create Shipping/Billing Address Details.'
            );
        }

        $cart = Cart::getCart();

        if ( ! $cart ) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.response.warning-empty-cart'),
                'Your cart is empty.'
            );
        }

        $billingAddressId = $params['billing_address_id'];
        $shippingAddressId = $params['shipping_address_id'];

        if (! $billingAddressId && (! isset($params['billing']) || (isset($params['billing']) && !$params['billing']))) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.response.billing-address-missing'),
                'Billing address missing.'
            );
        }
    
        if (! $shippingAddressId && (! isset($params['billing']['use_for_shipping']) || (isset($params['billing']['use_for_shipping']) && !$params['billing']['use_for_shipping'])) ) {
            if (! isset($params['shipping']) || (isset($params['shipping']) && !$params['shipping']) ) {
                throw new CustomException(
                    trans('bagisto_graphql::app.shop.response.shipping-address-missing'),
                    'Shipping address missing.'
                );
            }
        }
        
        try {
            $token = 0;
            if ( isset(getallheaders()['authorization'])) {
                $headerValue = explode("Bearer ", getallheaders()['authorization']);
                if ( isset($headerValue[1]) && $headerValue[1]) {
                    $token = $headerValue[1];
                }
            }

            $validateUser = bagisto_graphql()->apiAuth($token, $this->guard);
            
            if (! $token || ($token && isset($validateUser['success']) && $validateUser['success']) ) {
                if (! bagisto_graphql()->guard($this->guard)->check() && ! Cart::getCart()->hasGuestCheckoutItems()) {
                    throw new CustomException(
                        trans('bagisto_graphql::app.shop.response.wrong-error'),
                        'Cart have some item(s), which are not allowed for guest checkout.'
                    );
                }
                
                $data = [
                    'billing'   => [
                        'address1'          => '',
                        'first_name'        => $cart->customer_first_name,
                        'last_name'         => $cart->customer_last_name,
                        'email'             => $cart->customer_email,
                        'address_id'        => $billingAddressId,
                    ],
                    'shipping'   => [
                        'address1'          => '',
                        'first_name'        => $cart->customer_first_name,
                        'last_name'         => $cart->customer_last_name,
                        'email'             => $cart->customer_email,
                        'address_id'        => $shippingAddressId,
                    ]
                ];

                $address_flag = false; 

                if ( $billingAddressId ) {
                    $billingAddress = $this->customerAddressRepository->findOneWhere([
                        'id'            => $billingAddressId,
                        'address_type'  => 'customer'
                    ]);

                    if ( isset($billingAddress->id)) {
                        $data['billing']['first_name'] = $billingAddress->first_name;
                        $data['billing']['last_name'] = $billingAddress->last_name;
                        $data['billing']['address1'] = $billingAddress->address1;

                        if ( isset($params['billing']['use_for_shipping']) && $params['billing']['use_for_shipping'] == true ) {
                            unset($data['shipping']['address_id']);
                            $data['billing']['use_for_shipping'] = true;
                        } else {
                            $data['billing']['use_for_shipping'] = false;
                        }
                    } else {
                        throw new CustomException(
                            trans('bagisto_graphql::app.shop.response.no-billing-address-found', ['address_id' => $billingAddressId]),
                            'No billing address found.'
                        );
                    }
                } else {
                    $address_flag = true; 
                }

                if ( $shippingAddressId ) {
                    $shippingAddress = $this->customerAddressRepository->findOneWhere([
                        'id'            => $shippingAddressId,
                        'address_type'  => 'customer'
                    ]);

                    if ( isset($shippingAddress->id)) {
                        $data['shipping']['address1'] = $shippingAddress->address1;
                    } else {
                        throw new CustomException(
                            trans('bagisto_graphql::app.shop.response.no-shipping-address-found', ['address_id' => $shippingAddressId]),
                            'No shipping address found.'
                        );
                    }
                } else {
                    $address_flag = true; 
                }
            
                if ( $address_flag == true ) {
                    if (! $billingAddressId && isset($params['billing']['address1'])) {
                        $data['billing'] = $params['billing'];

                        if ( isset($params['billing']['use_for_shipping']) && $params['billing']['use_for_shipping'] == true ) {
                            unset($data['shipping']['address_id']);
                        }
                    }

                    if (! $shippingAddressId && isset($params['shipping']['address1'])) {

                        if (! isset($params['billing']['use_for_shipping']) || (isset($params['billing']['use_for_shipping']) && !$params['billing']['use_for_shipping']) ) {
                            $data['shipping'] = $params['shipping'];
                        }
                    }

                    if ( isset($cart['is_guest']) && $cart['is_guest'] == 1) {
                        $data['billing']['customer_id'] = $data['shipping']['customer_id'] = null;
                    }
                }

                if (Cart::hasError() || ! Cart::saveCustomerAddress($data)) {
                    throw new CustomException(
                        trans('bagisto_graphql::app.shop.response.wrong-error'),
                        'Cart have some item(s), which are not allowed for guest checkout.'
                    );
                } else {
                    $coreCurrency = config('app.currency');
                    if ( isset($params['currency']) && $params['currency'] ) {
                        $coreCurrency = $params['currency'];
                    }
        
                    Cart::collectTotals();
        
                    if ($cart->haveStockableItems() && $params['type'] == 'shipping') {
                        if (! $rates = Shipping::collectRates()) {
                            throw new CustomException(
                                trans('bagisto_graphql::app.shop.response.wrong-error'),
                                'Error in fatching shipping rate.'
                            );
                        } else {
                            $shipping_methods = [];
                            foreach ($rates['shippingMethods'] as $shippingMethod) {
                                $methods = [];
                                foreach ($shippingMethod['rates'] as $rate) {
                                    $methods = [
                                        'code'              => $rate->method,
                                        'label'             => $rate->method_title,
                                        'price'             => core()->convertPrice($rate->price, $coreCurrency),
                                        'formatted_price'   => core()->formatPrice(core()->convertPrice($rate->price, $coreCurrency), $coreCurrency),
                                        'base_price'        => core()->convertPrice($rate->base_price, core()->getBaseCurrencyCode()),
                                        'formatted_base_price'=> core()->formatPrice(core()->convertPrice($rate->base_price, core()->getBaseCurrencyCode()), core()->getBaseCurrencyCode())
                                    ];
                                }
                                $shipping_methods[] = [
                                    'title'     => $shippingMethod['carrier_title'],
                                    'methods'   => $methods,
                                ];
                            }
                            
                            return [
                                'success'           => trans('bagisto_graphql::app.shop.response.save-cart-address'),
                                'cart'              => Cart::getCart(),
                                'cart_total'        => core()->formatPrice(core()->convertPrice($cart->grand_total, $coreCurrency), $coreCurrency),
                                'cart_count'        => $cart ? count($cart->items) : 0,
                                'shipping_methods'  => $shipping_methods,
                                'jump_to_section'   => 'shipping',
                            ];
                        }
                    } else {
                        return [
                            'success'           => trans('bagisto_graphql::app.shop.response.save-cart-address'),
                            'cart'              => Cart::getCart(),
                            'cart_total'        => core()->formatPrice(core()->convertPrice($cart->grand_total, $coreCurrency), $coreCurrency),
                            'cart_count'        => $cart ? count($cart->items) : 0,
                            'payment_methods'   => Payment::getPaymentMethods(),
                            'jump_to_section'   => 'payment',
                        ];
                    }
                }
            } elseif ($token && isset($validateUser['success']) && !$validateUser['success']) {
                if ( $billingAddressId || $shippingAddressId) {
                    throw new CustomException(
                        trans('bagisto_graphql::app.shop.response.invalid-guest-access'),
                        'invalid-guest-access.'
                    );
                } else {
                    throw new CustomException(
                        trans('bagisto_graphql::app.shop.response.guest-address-warning'),
                        'guest-address-warning.'
                    );
                }
            }
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                'Error in saving shipping/billing address.'
            );
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

        if ( ! $cart ) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.response.warning-empty-cart'),
                'Your cart is empty.'
            );
        }
        
        try {
            $token = 0;
            if ( isset(getallheaders()['authorization'])) {
                $headerValue = explode("Bearer ", getallheaders()['authorization']);
                if ( isset($headerValue[1]) && $headerValue[1]) {
                    $token = $headerValue[1];
                }
            }

            $validateUser = bagisto_graphql()->apiAuth($token, $this->guard);
            
            if (! $token || ($token && isset($validateUser['success']) && $validateUser['success']) ) {
                if (! bagisto_graphql()->guard($this->guard)->check() && ! Cart::getCart()->hasGuestCheckoutItems()) {
                    throw new CustomException(
                        trans('bagisto_graphql::app.shop.response.wrong-error'),
                        'Cart have some item(s), which are not allowed for guest checkout.'
                    );
                }
                
                if (!isset($cart->shipping_address->id)) {
                    throw new CustomException(
                        'Error: No shipping/billing address found for the current cart.',
                        'Error in fetching shipping/billing address.'
                    );
                } else {
                    $coreCurrency = config('app.currency');
                    if ( isset($params['currency']) && $params['currency'] ) {
                        $coreCurrency = $params['currency'];
                    }
        
                    Cart::collectTotals();
        
                    if ($cart->haveStockableItems()) {
                        if (! $rates = Shipping::collectRates()) {
                            throw new CustomException(
                                trans('bagisto_graphql::app.shop.response.wrong-error'),
                                'Error in fatching shipping rate.'
                            );
                        } else {
                            $shipping_methods = [];
                            foreach ($rates['shippingMethods'] as $shippingMethod) {
                                $methods = [];
                                foreach ($shippingMethod['rates'] as $rate) {
                                    $methods = [
                                        'code'              => $rate->method,
                                        'label'             => $rate->method_title,
                                        'price'             => core()->convertPrice($rate->price, $coreCurrency),
                                        'formatted_price'   => core()->formatPrice(core()->convertPrice($rate->price, $coreCurrency), $coreCurrency),
                                        'base_price'        => core()->convertPrice($rate->base_price, core()->getBaseCurrencyCode()),
                                        'formatted_base_price'=> core()->formatPrice(core()->convertPrice($rate->base_price, core()->getBaseCurrencyCode()), core()->getBaseCurrencyCode())
                                    ];
                                }
                                $shipping_methods[] = [
                                    'title'     => $shippingMethod['carrier_title'],
                                    'methods'   => $methods,
                                ];
                            }
                            
                            return [
                                'success'           => 'Success: Shipping Methods fetched successfully',
                                'cart_total'        => core()->formatPrice(core()->convertPrice($cart->grand_total, $coreCurrency), $coreCurrency),
                                'cart_count'        => $cart ? count($cart->items) : 0,
                                'shipping_methods'  => $shipping_methods,
                                'jump_to_section'   => 'shipping',
                            ];
                        }
                    } else {
                        return [
                            'success'           => trans('bagisto_graphql::app.shop.response.save-cart-address'),
                            'cart_total'        => core()->formatPrice(core()->convertPrice($cart->grand_total, $coreCurrency), $coreCurrency),
                            'cart_count'        => $cart ? count($cart->items) : 0,
                            'payment_methods'   => Payment::getPaymentMethods(),
                            'jump_to_section'   => 'payment',
                        ];
                    }
                }
            } elseif ($token && isset($validateUser['success']) && !$validateUser['success']) {
                throw new CustomException(
                    trans('bagisto_graphql::app.shop.response.guest-address-warning'),
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
        if (! isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new CustomException(
                trans('bagisto_graphql::app.admin.response.error-invalid-parameter'),
                'Invalid request parameters.'
            );
        }

        $data = $args['input'];
        
        $validator = \Validator::make($data, [
            'shipping_method'   => 'string|required',
        ]);
        
        if ($validator->fails()) {
            $errorMessage = [];
            foreach ($validator->messages()->toArray() as $field => $message) {
                $errorMessage[] = is_array($message) ? $message[0] : $message;
            }
            
            throw new CustomException(
                implode(" ,", $errorMessage),
                'Invalid choosing shipping method.'
            );
        }
        
        try {
            $coreCurrency = config('app.currency');
            if ( isset($data['currency']) && $data['currency'] ) {
                $coreCurrency = $data['currency'];
            }

            $cart = Cart::getCart();

            if (Cart::hasError() || !Cart::saveShippingMethod($data['shipping_method'])) {
                throw new CustomException(
                    trans('bagisto_graphql::app.shop.response.error-payment-selection'),
                    'Error in saving shipping method.'
                );
            }
    
            Cart::collectTotals();
            
            return [
                'success'           => trans('bagisto_graphql::app.shop.response.selected-shipment'),
                'cart'              => Cart::getCart(),
                'cart_total'        => core()->formatPrice(core()->convertPrice($cart->grand_total, $coreCurrency), $coreCurrency),
                'cart_count'        => $cart ? count($cart->items) : 0,
                'payment_methods'   => Payment::getPaymentMethods(),
                'jump_to_section'   => 'payment',
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
        if (! isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new CustomException(
                trans('bagisto_graphql::app.admin.response.error-invalid-parameter'),
                'Invalid request parameters.'
            );
        }

        $data = $args['input'];
        
        $validator = \Validator::make($data, [
            'payment'   => 'array|required',
        ]);
        
        if ($validator->fails()) {
            $errorMessage = [];
            foreach ($validator->messages()->toArray() as $field => $message) {
                $errorMessage[] = is_array($message) ? $message[0] : $message;
            }
            
            throw new CustomException(
                implode(" ,", $errorMessage),
                'Invalid choosing shipping method.'
            );
        }
        
        try {
            if (Cart::hasError() || ! Cart::savePaymentMethod($data['payment'])) {
            
                throw new CustomException(
                    trans('bagisto_graphql::app.shop.response.error-payment-save'),
                    'Error in saving payment method.'
                );
            }

            Cart::collectTotals();

            $cart = Cart::getCart();

            return [
                'success'           => trans('bagisto_graphql::app.shop.response.selected-payment'),
                'jump_to_section'   => 'review',
                'cart'              => $cart
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
     * @param  array  $args
     * @return \Illuminate\Http\Response
     */
    public function applyCoupon($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];
        
        $validator = \Validator::make($data, [
            'code'   => 'string|required',
        ]);
        
        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }
        
        try {
            if (strlen($data['code'])) {
                Cart::setCouponCode($data['code'])->collectTotals();

                if (Cart::getCart()->coupon_code == $data['code']) {
                    return [
                        'success' => true,
                        'message' => trans('shop::app.checkout.total.success-coupon'),
                    ];
                }
            }

            return [
                'success' => false,
                'message' => trans('shop::app.checkout.total.invalid-coupon'),
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Create order
     *
     * @param  array  $args
     * @return \Illuminate\Http\Response
     */
    public function saveOrder($rootValue, array $args, GraphQLContext $context)
    {
        try {
            if (Cart::hasError()) {
                throw new CustomException(
                    trans('bagisto_graphql::app.shop.response.error-placing-order'),
                    'Some error found in cart.'
                );
            }
    
            Cart::collectTotals();
    
            $this->validateOrder();
    
            $cart = Cart::getCart();
    
            if ($redirectUrl = Payment::getRedirectUrl($cart)) {
                return [
                    'success'           => true,
                    'redirect_url'      => $redirectUrl,
                    'selected_method'   => $cart->payment->method,
                ];
            }
    
            $order = $this->orderRepository->create(Cart::prepareDataForOrder());
    
            Cart::deActivateCart();
    
            session()->flash('order', $order);
    
            return [
                'success'       => true,
                'redirect_url'  => null,
                'order'         => $order
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
     * @return void|\Exception
     */
    public function validateOrder()
    {
        $cart = Cart::getCart();

        if ($cart->haveStockableItems() && ! $cart->shipping_address) {
            throw new \Exception(trans('Please check shipping address.'));
        }

        if (! $cart->billing_address) {
            throw new \Exception(trans('Please check billing address.'));
        }

        if ($cart->haveStockableItems() && ! $cart->selected_shipping_rate) {
            throw new \Exception(trans('Please specify shipping method.'));
        }

        if (! $cart->payment) {
            throw new \Exception(trans('Please specify payment method.'));
        }
    }
}