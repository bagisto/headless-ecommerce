<?php

namespace Webkul\GraphQLAPI\Queries\Velocity;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Queries\BaseFilter;
use Webkul\Checkout\Facades\Cart as BaseCart;
use Webkul\Checkout\Repositories\CartRepository;

class Cart extends BaseFilter
{

    /**
     * Cart repository instance.
     *
     * @var \Webkul\Checkout\Repositories\CartRepository
     */
    protected $cartRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Checkout\Repositories\CartRepository  $cartRepository
     * @return void
     */
    public function __construct(
        CartRepository $cartRepository
    ) {
        $this->cartRepository = $cartRepository;

        $this->_config = request('_config');
    }
    /**
     * Get formatted price for Cart data.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return mixed
     */
    public function getCart($rootValue, array $args, GraphQLContext $context)
    {
        $cart = BaseCart::getCart();
        if ($cart) {
            return $cart;
        }

        if ( bagisto_graphql()->guard('api')->check() ) {
            $customer_id = bagisto_graphql()->guard('api')->user()->id;

            $cart = $this->cartRepository->findOneWhere([
                'customer_id' => $customer_id,
                'is_active'   => 1,
            ]);
        } else if (session()->has('cart')) {
            $cart = $this->cartRepository->find(session()->get('cart')->id);
        }

        return $cart;
    }
}
