<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Sales\Refunds;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Sales\Repositories\OrderItemRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\RefundRepository;

class RefundMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected OrderItemRepository $orderItemRepository,
        protected RefundRepository $refundRepository
    ) {}

    /**
     * Store a newly created resource in storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $order = $this->orderRepository->find($args['order_id']);

        if (! $order) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.orders.not-found'));
        }

        if (! $order->canRefund()) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.refunds.creation-error'));
        }

        try {
            if (! isset($args['refund_data'])) {
                throw new CustomException(trans('bagisto_graphql::app.admin.sales.refunds.creation-error'));
            }

            $refundData = [];

            foreach ($args['refund_data'] as $arg) {
                $refundData = $refundData + [
                    $arg['order_item_id'] => $arg['quantity'],
                ];
            }

            $data['refund']['items'] = $refundData;
            $data['refund']['shipping'] = $args['refund_shipping'];
            $data['refund']['adjustment_refund'] = $args['adjustment_refund'];
            $data['refund']['adjustment_fee'] = $args['adjustment_fee'];

            bagisto_graphql()->validate($data, [
                'refund.items.*' => 'required|numeric|min:0',
            ]);

            $totals = $this->refundRepository->getOrderItemsRefundSummary($data['refund'], $args['order_id']);

            if ($totals != false) {
                $maxRefundAmount = $totals['grand_total']['price'] - $order->refunds()->sum('base_adjustment_refund');

                $refundAmount = $totals['grand_total']['price'] - $totals['shipping']['price'] + $data['refund']['shipping'] + $data['refund']['adjustment_refund'] - $data['refund']['adjustment_fee'];
            }

            if (! isset($refundAmount)) {
                throw new CustomException(trans('bagisto_graphql::app.admin.sales.refunds.refund-amount-error'));
            }

            if ($refundAmount > $maxRefundAmount) {
                throw new CustomException(trans('bagisto_graphql::app.admin.sales.refunds.refund-limit-error', ['amount' => core()->formatBasePrice($maxRefundAmount)]));
            }

            $refund = $this->refundRepository->create(array_merge($data, [
                'order_id' => $args['order_id'],
            ]));

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.sales.refunds.create-success'),
                'refund'  => $refund,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
