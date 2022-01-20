<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Customer;

use Webkul\Customer\Http\Controllers\Controller;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Log;

class CustomerOrderQuery extends Controller
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
     * @return void
     */
    public function __construct()
    {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);
        
        $this->middleware('auth:' . $this->guard);
    }

    /**
     * Returns loggedin customer's reviews data.
     *
     * @return \Illuminate\Http\Response
     */
    public function orders($query, $input, $test)
    {
        $params = $input;
        
        if ( bagisto_graphql()->guard($this->guard)->check() ) {
            $params['customer_id'] = bagisto_graphql()->guard($this->guard)->user()->id;
        }
        Log::error('Order Params: ' . json_encode($params));
        
        $qb = $query->distinct()
            ->addSelect('orders.*');

        if ( isset($params['id']) && $params['id']) {
            $qb->where('orders.id', $params['id']);
        }

        if ( isset($params['incrementId']) && $params['incrementId']) {
            $qb->where('orders.incrementId', $params['incrementId']);
        }

        if ( isset($params['baseSubTotal']) && $params['baseSubTotal']) {
            $qb->where('orders.baseSubTotal', $params['baseSubTotal']);
        }

        if ( isset($params['baseGrandTotal']) && $params['baseGrandTotal']) {
            $qb->where('orders.baseGrandTotal', $params['baseGrandTotal']);
        }

        if ( isset($params['baseGrandTotal']) && $params['baseGrandTotal']) {
            $qb->where('orders.baseGrandTotal', $params['baseGrandTotal']);
        }

        if ( isset($params['orderDate']) && $params['orderDate']) {
            $qb->where('orders.orderDate', 'like', '%' . urldecode($params['orderDate']) . '%');
        }
        
        if ( isset($params['customer_id']) && $params['customer_id']) {
            $qb->where('orders.customer_id', $params['customer_id']);
        }

        if ( isset($params['status']) && $params['status']) {
            $qb->where('orders.status', $params['status']);
        }

        return $qb;
    }

    public function getOrderPaymentAdditional($rootValue, array $args, GraphQLContext $context)
    {
        return \Webkul\Payment\Payment::getAdditionalDetails($rootValue->method);
    }

    public function getOrderPaymentTitle($rootValue, array $args, GraphQLContext $context)
    {
        return core()->getConfigData('sales.paymentmethods.' . $rootValue->method . '.title');
    }
}



