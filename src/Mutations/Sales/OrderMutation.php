<?php

namespace Webkul\GraphQLAPI\Mutations\Sales;

use Exception;
use Webkul\Admin\Http\Controllers\Controller;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Sales\Repositories\OrderRepository;

class OrderMutation extends Controller
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
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository
    ) {
        $this->guard = 'admin-api';

        auth()->setDefaultDriver($this->guard);

        $this->_config = request('_config');
    }

    /**
     * Remove a resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel($rootValue, array $args, GraphQLContext $context)
    {
        if (!isset($args['id']) || (isset($args['id']) && !$args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $orderId = $args['id'];

        $order = $this->orderRepository->findOrFail($orderId);

        if (!$order->canCancel() || !$order->canInvoice()) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.cancel-error'));
        }

        try {
            $result = $this->orderRepository->cancel($orderId);

            return [
                'status'    => $result ? true : false,
                'order'     => $this->orderRepository->find($orderId),
                'message'   => $result ? trans('admin::app.response.cancel-success', ['name' => 'Order']) : trans('bagisto_graphql::app.admin.response.cancel-error')
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
