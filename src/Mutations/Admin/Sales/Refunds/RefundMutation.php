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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['input'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $params = $args['input'];

        $orderId = $params['order_id'];

        $order = $this->orderRepository->find($orderId);

        if (! $order) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.orders.not-found'));
        }

        if (! $order->canRefund()) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.refunds.creation-error'));
        }

        try {
            if (! isset($params['refund_data'])) {
                throw new CustomException(trans('bagisto_graphql::app.admin.sales.refunds.creation-error'));
            }

            $refundData = [];

            foreach ($params['refund_data'] as $data) {
                $refundData = $refundData + [
                    $data['order_item_id'] => $data['quantity'],
                ];
            }

            $refund['refund']['items'] = $refundData;
            $refund['refund']['shipping'] = $params['refund_shipping'];
            $refund['refund']['adjustment_refund'] = $params['adjustment_refund'];
            $refund['refund']['adjustment_fee'] = $params['adjustment_fee'];

            bagisto_graphql()->validate($refund, [
                'refund.items.*' => 'required|numeric|min:0',
            ]);

            $totals = $this->refundRepository->getOrderItemsRefundSummary($refund['refund']['items'], $orderId);

            if ($totals != false) {
                $maxRefundAmount = $totals['grand_total']['price'] - $order->refunds()->sum('base_adjustment_refund');

                $refundAmount = $totals['grand_total']['price'] - $totals['shipping']['price'] + $refund['refund']['shipping'] + $refund['refund']['adjustment_refund'] - $refund['refund']['adjustment_fee'];
            }

            if (! isset($refundAmount)) {
                throw new CustomException(trans('bagisto_graphql::app.admin.sales.refunds.invalid-refund-amount-error'));
            }

            if ($refundAmount > $maxRefundAmount) {
                throw new CustomException(trans('bagisto_graphql::app.admin.sales.refunds.refund-limit-error').core()->formatBasePrice($maxRefundAmount));
            }

            $refundedData = $this->refundRepository->create(array_merge($refund, ['order_id' => $orderId]));

            if (isset($refundedData->id)) {
                $refundedData->success = trans('bagisto_graphql::app.admin.sales.refunds.create-success');

                return $refundedData;
            }

            throw new CustomException(trans('bagisto_graphql::app.admin.sales.refunds.creation-error'));
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
