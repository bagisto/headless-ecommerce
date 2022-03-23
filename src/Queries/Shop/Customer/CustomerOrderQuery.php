<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Customer;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Customer\Http\Controllers\Controller;
use Webkul\Sales\Repositories\OrderRepository;

class CustomerOrderQuery extends Controller
{
    /**
     * Contains current guard.
     *
     * @var array
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);

        $this->middleware('auth:' . $this->guard);
    }

    /**
     * Returns loggedin customer's orders data.
     *
     * @param  mixed  $query
     * @param  mixed  $input
     * @param  mixed  $test
     * @return mixed
     */
    public function orders($query, $input, $test)
    {
        $params = $input;

        if (! bagisto_graphql()->guard($this->guard)->check()) {
            return null;
        }

        $qb = app(OrderRepository::class)->query()->distinct()->addSelect('orders.*');

        $params['customer_id'] = bagisto_graphql()->guard($this->guard)->user()->id;

        if (isset($params['input']['id']) && $params['input']['id']) {
            $qb->where('orders.id', $params['input']['id']);
        }

        if (isset($params['incrementId']) && $params['incrementId']) {
            $qb->where('orders.incrementId', $params['incrementId']);
        }

        if (isset($params['baseSubTotal']) && $params['baseSubTotal']) {
            $qb->where('orders.baseSubTotal', $params['baseSubTotal']);
        }

        if (isset($params['baseGrandTotal']) && $params['baseGrandTotal']) {
            $qb->where('orders.baseGrandTotal', $params['baseGrandTotal']);
        }

        if (isset($params['baseGrandTotal']) && $params['baseGrandTotal']) {
            $qb->where('orders.baseGrandTotal', $params['baseGrandTotal']);
        }

        if (isset($params['orderDate']) && $params['orderDate']) {
            $qb->where('orders.orderDate', 'like', '%' . urldecode($params['orderDate']) . '%');
        }

        if (isset($params['customer_id']) && $params['customer_id']) {
            $qb->where('orders.customer_id', $params['customer_id']);
        }

        if (isset($params['status']) && $params['status']) {
            $qb->where('orders.status', $params['status']);
        }

        return $qb->orderBy('orders.id', 'desc');
    }

    /**
     * Get order payment additional data.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return [type]
     */
    public function getOrderPaymentAdditional($rootValue, array $args, GraphQLContext $context)
    {
        return \Webkul\Payment\Payment::getAdditionalDetails($rootValue->method);
    }

    /**
     * Get order payment title.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return mixed
     */
    public function getOrderPaymentTitle($rootValue, array $args, GraphQLContext $context)
    {
        return core()->getConfigData('sales.paymentmethods.' . $rootValue->method . '.title');
    }
}
