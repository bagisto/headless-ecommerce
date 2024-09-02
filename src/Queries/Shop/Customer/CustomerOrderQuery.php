<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Customer;

use Illuminate\Database\Eloquent\Builder;
use Webkul\Payment\Payment;
use Webkul\Sales\Repositories\OrderRepository;

class CustomerOrderQuery
{
    /**
     * Returns logged in customer's orders data.
     */
    public function orders(mixed $rootValue, array $input): Builder
    {
        $qb = app(OrderRepository::class)->query()->distinct()->addSelect('orders.*');

        if (! empty($input['id'])) {
            $qb->where('orders.id', $input['id']);
        }

        if (! empty($input['increment_id'])) {
            $qb->where('orders.increment_id', $input['increment_id']);
        }

        if (! empty($input['base_sub_total'])) {
            $qb->where('orders.base_sub_total', $input['base_sub_total']);
        }

        if (! empty($input['base_grand_total'])) {
            $qb->where('orders.base_grand_total', $input['base_grand_total']);
        }

        if (! empty($input['channel_name'])) {
            $qb->where('orders.channel_name', $input['channel_name']);
        }

        if (! empty($input['order_date'])) {
            $qb->where('orders.created_at', 'like', '%'.urldecode($input['order_date']).'%');
        }

        if (
            ! empty($input['start_order_date'])
            && ! empty($input['end_order_date'])
        ) {
            $qb->whereBetween('orders.created_at', [$input['start_order_date'], $input['end_order_date']]);
        }

        if (! empty($input['status'])) {
            $qb->where('orders.status', $input['status']);
        }

        $qb->where('orders.customer_id', auth()->user()->id);

        return $qb->orderBy('orders.id', 'desc');
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
    public function getTranslatedOrderStatus(mixed $rootValue)
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

        return $statusLabel[$rootValue->status];
    }
}
