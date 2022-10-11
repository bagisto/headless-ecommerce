<?php

namespace Webkul\GraphQLAPI\Queries\Velocity;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Queries\BaseFilter;
use Webkul\Checkout\Facades\Cart as BaseCart;

class Cart extends BaseFilter
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

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
        return BaseCart::getCart();
    }
}
