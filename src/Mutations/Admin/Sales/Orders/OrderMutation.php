<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Sales\Orders;

use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Sales\Repositories\OrderRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Validators\Admin\CustomException;

class OrderMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Sales\Repositories\OrderRepository  $orderRepository
     * @return void
     */
    public function __construct(protected OrderRepository $orderRepository)
    {
    }

    /**
     * Remove a resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['id'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $orderId = $args['id'];

        $order = $this->orderRepository->find($orderId);

        if (! $order) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.orders.not-found'));
        }

        if (
            ! $order->canCancel()
            || ! $order->canInvoice()
        ) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.orders.cancel-error'));
        }

        try {
            $result = $this->orderRepository->cancel($orderId);

            return [
                'status'  => $result,
                'order'   => $this->orderRepository->find($orderId),
                'message' => $result ? trans('bagisto_graphql::app.admin.sales.orders.cancel-success') : trans('bagisto_graphql::app.admin.sales.orders.cancel-error')
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
