<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
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
     * Reorder a customer's order.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function reorder(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $customer = bagisto_graphql()->authorize();

        $order = $this->orderRepository->findOneWhere([
            'id'          => $args['id'],
            'customer_id' => $customer->id,
        ]);

        if (! $order) {
            return [
                'success' => false,
                'message' => trans('bagisto_graphql::app.shop.customers.account.orders.not-found'),
                'cart'    => Cart::getCart(),
            ];
        }

        foreach ($order->items as $item) {
            try {
                Cart::addProduct($item->product, $item->additional);
            } catch (\Exception $e) {
            }
        }

        return [
            'success' => true,
            'message' => trans('bagisto_graphql::app.shop.checkout.cart.item.success.add-to-cart'),
            'cart'    => Cart::getCart(),
        ];
    }

    /**
     * Remove a resource from storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function cancel(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $customer = bagisto_graphql()->authorize();

        try {
            $order = $this->orderRepository->findOneWhere([
                'id'          => $args['id'],
                'customer_id' => $customer->id,
            ]);

            if (! $order) {
                throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.orders.cancel-error'));
            }

            $result = $this->orderRepository->cancel($order);

            return [
                'success' => $result,
                'message' => $result
                    ? trans('bagisto_graphql::app.shop.customers.account.orders.cancel-success')
                    : trans('bagisto_graphql::app.shop.customers.account.orders.cancel-error'),
                'order'   => $order->refresh(),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
