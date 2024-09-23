<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Customer;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Webkul\Payment\Payment;

class OrderQuery
{
    /**
     * Filter query for customer orders.
     */
    public function __invoke(mixed $query, array $input): Builder
    {
        $customer = bagisto_graphql()->authorize();

        $query->where('customer_id', $customer->id);

        $params = Arr::except($input, ['order_date']);

        $query->when(! empty($input['order_date']), function ($query) use ($input) {
            $query->whereDate('created_at', $input['order_date']);
        });

        return $query->where($params)->orderBy('id', 'desc');
    }

    /**
     * Get the specified order.
     */
    public function getOrder(Builder $query): Builder
    {
        $customer = bagisto_graphql()->authorize();

        return $query->where('customer_id', $customer->id);
    }

    /**
     * Get order payment additional data.
     *
     * @return mixed
     */
    public function getOrderPaymentAdditional(mixed $orderPayment)
    {
        return Payment::getAdditionalDetails($orderPayment->method);
    }

    /**
     * Get order payment title.
     *
     * @return mixed
     */
    public function getOrderPaymentTitle(mixed $rootValue)
    {
        return core()->getConfigData('sales.payment_methods.'.$rootValue->method.'.title');
    }

    /**
     * Get Translated Order Status.
     *
     * @return string
     */
    public function getTranslatedOrderStatus(object $order)
    {
        $statusLabel = [
            'pending'         => trans('shop::app.customers.account.orders.status.options.pending'),
            'pending_payment' => trans('shop::app.customers.account.orders.status.options.pending-payment'),
            'processing'      => trans('shop::app.customers.account.orders.status.options.processing'),
            'completed'       => trans('shop::app.customers.account.orders.status.options.completed'),
            'canceled'        => trans('shop::app.customers.account.orders.status.options.canceled'),
            'closed'          => trans('shop::app.customers.account.orders.status.options.closed'),
            'fraud'           => trans('shop::app.customers.account.orders.status.options.fraud'),
        ];

        return $statusLabel[$order->status];
    }
}
