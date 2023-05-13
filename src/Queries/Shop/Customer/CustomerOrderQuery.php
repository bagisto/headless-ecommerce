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

        $params['input']['customer_id'] = bagisto_graphql()->guard($this->guard)->user()->id;

        if (! empty($params['input']['id'])) {
            $qb->where('orders.id', $params['input']['id']);
        }

        if (! empty($params['input']['increment_id'])) {
            $qb->where('orders.increment_id', $params['input']['increment_id']);
        }

        if (! empty($params['input']['base_sub_total'])) {
            $qb->where('orders.base_sub_total', $params['input']['base_sub_total']);
        }

        if (! empty($params['input']['base_grand_total'])) {
            $qb->where('orders.base_grand_total', $params['input']['base_grand_total']);
        }

        if (! empty($params['input']['channel_name'])) {
            $qb->where('orders.channel_name', $params['input']['channel_name']);
        }

        if (! empty($params['input']['order_date'])) {
            $qb->where('orders.created_at', 'like', '%' . urldecode($params['input']['order_date']) . '%');
        }

        if (! empty($params['input']['start_order_date']) && ! empty($params['input']['end_order_date'])) {
            $qb->whereBetween('orders.created_at', [$params['input']['start_order_date'], $params['input']['end_order_date']]);
        }

        if (! empty($params['input']['customer_id'])) {
            $qb->where('orders.customer_id', $params['input']['customer_id']);
        }

        if (! empty($params['input']['status'])) {
            $qb->where('orders.status', $params['input']['status']);
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
