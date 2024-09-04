<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Sales\Orders;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Checkout\Facades\Cart;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Sales\Repositories\OrderRepository;

class OrderMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected OrderRepository $orderRepository) {}

    /**
     * Cancel the specified order.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function cancel(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $order = $this->orderRepository->find($args['id']);

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
            $result = $this->orderRepository->cancel($args['id']);

            return [
                'success' => $result,
                'message' => $result
                    ? trans('bagisto_graphql::app.admin.sales.orders.cancel-success')
                    : trans('bagisto_graphql::app.admin.sales.orders.cancel-error'),
                'order'   => $this->orderRepository->find($args['id']),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Reorder the specified order.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function reorder(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $order = $this->orderRepository->find($args['id']);

        if (! $order) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.orders.not-found'));
        }

        $cart = Cart::createCart([
            'customer'  => $order->customer,
            'is_active' => false,
        ]);

        Cart::setCart($cart);

        foreach ($order->items as $item) {
            try {
                Cart::addProduct($item->product, $item->additional);
            } catch (\Exception $e) {
            }
        }

        $cart->refresh();

        return [
            'success'            => true,
            'jump_to_section'    => 'create_order',
            'cart'               => $cart,
            'customer_addresses' => $cart->customer->addresses,
        ];
    }
}
