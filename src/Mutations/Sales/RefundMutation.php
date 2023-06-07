<?php

namespace Webkul\GraphQLAPI\Mutations\Sales;

use Exception;
use Illuminate\Support\Facades\Validator;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\RefundRepository;
use Webkul\Sales\Repositories\OrderItemRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class RefundMutation extends Controller
{
    /**
     * Initialize _config, a default request parameter with route
     *
     * @param array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Sales\Repositories\OrderRepository  $orderRepository
     * @param  \Webkul\Sales\Repositories\RefundRepository  $refundRepository
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected OrderItemRepository $orderItemRepository,
        protected RefundRepository $refundRepository
    ) {
        $this->guard = 'admin-api';

        auth()->setDefaultDriver($this->guard);

        $this->_config = request('_config');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $params = $args['input'];
        $orderId = $params['order_id'];

        $order = $this->orderRepository->findOrFail($orderId);

        if (! $order->canRefund()) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.creation-error'));
        }

        try {

            $refundData= [];

            if (isset($params['refund_data'])) {

                foreach ($params['refund_data'] as $data) {

                    $refundData = $refundData + [
                        $data['order_item_id'] => $data['quantity']
                    ];
                }

                $refund['refund']['items']=  $refundData;

                $refund['refund']['shipping']          = $params['refund_shipping'];
                $refund['refund']['adjustment_refund'] = $params['adjustment_refund'];
                $refund['refund']['adjustment_fee']    = $params['adjustment_fee'];

                $validator = Validator::make($refund, [
                    'refund.items.*' => 'required|numeric|min:0',
                ]);

                if ($validator->fails()) {
                    throw new Exception($validator->messages());
                }


                $totals = $this->refundRepository->getOrderItemsRefundSummary($refund['refund']['items'], $orderId);

                if ($totals != false) {
                    $maxRefundAmount = $totals['grand_total']['price'] - $order->refunds()->sum('base_adjustment_refund');

                    $refundAmount = $totals['grand_total']['price'] - $totals['shipping']['price'] + $refund['refund']['shipping'] + $refund['refund']['adjustment_refund'] - $refund['refund']['adjustment_fee'];
                }


                if (! isset($refundAmount)) {
                    throw new Exception(trans('admin::app.sales.refunds.invalid-refund-amount-error'));
                }

                if ($refundAmount > $maxRefundAmount) {

                    throw new Exception(trans('admin::app.sales.refunds.refund-limit-error') . core()->formatBasePrice($maxRefundAmount));
                }

                $refundedData = $this->refundRepository->create(array_merge($refund, ['order_id' => $orderId]));

                if ( isset($refundedData->id) ) {
                    $refundedData->success = trans('admin::app.response.create-success', ['name' => 'Refund']);

                    return $refundedData;
                } else {
                    throw new Exception(trans('admin::app.sales.refunds.creation-error'));
                }
            } else {
                throw new Exception(trans('admin::app.sales.refunds.creation-error'));
            }
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}

