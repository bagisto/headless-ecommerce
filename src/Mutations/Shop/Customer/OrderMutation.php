<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Exception;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\ShipmentRepository;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\RefundRepository;

class OrderMutation extends Controller
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
     * @param  \Webkul\Sales\Repositories\OrderRepository  $orderRepository
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository
    ) {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);

        $this->middleware('auth:' . $this->guard);
    }

    /**
     * Returns a current customer's order detail.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function order($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['id']) || (isset($args['id']) && !$args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        if (bagisto_graphql()->guard($this->guard)->check()) {
            $customer = bagisto_graphql()->guard($this->guard)->user();

            $order = $this->orderRepository->findOneWhere([
                'id'            => $args['id'],
                'customer_id'   => $customer->id,
            ]);

            if (! empty($order->id)) {
                return $order;
            } else {
                throw new Exception(trans('bagisto_graphql::app.shop.response.no-order-found'));
            }
        } else {
            throw new Exception(trans('bagisto_graphql::app.shop.customer.no-login-customer'));
        }
    }

    /**
     * Returns a current customer's orders data.
     *
     * @return \Illuminate\Http\Response
     */
    public function orders($rootValue, array $args, GraphQLContext $context)
    {
        $params = $args['input'];

        if (bagisto_graphql()->guard($this->guard)->check()) {
            $customer = bagisto_graphql()->guard($this->guard)->user();

            $currentPage = isset($params['page']) ? $params['page'] : 1;

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });

            $orders = app(OrderRepository::class)->scopeQuery(function ($query) use ($customer, $params) {

                return $query->distinct()
                    ->addSelect('orders.*')
                    ->where('orders.customer_id', $customer->id);
            })->paginate(isset($params['limit']) ? $params['limit'] : 10);

            if (count($orders)) {
                return $orders;
            } else {
                throw new Exception(trans('bagisto_graphql::app.shop.response.not-found', ['name'   => 'Order']));
            }
        } else {
            throw new Exception(trans('bagisto_graphql::app.shop.customer.no-login-customer'));
        }
    }

    /**
     * Remove a resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['id']) || (isset($args['id']) && !$args['id'])) {
            throw new Exception(
                trans('bagisto_graphql::app.admin.response.error-invalid-parameter'),
                'Invalid request parameter.'
            );
        }

        if (! bagisto_graphql()->guard($this->guard)->check() ) {
            throw new Exception(
                trans('bagisto_graphql::app.shop.customer.no-login-customer'),
                'Customer Not Login.'
            );
        }

        $orderId = $args['id'];

        try {
            $customer = bagisto_graphql()->guard($this->guard)->user();

            $order = $this->orderRepository->findOneWhere([
                'id'            => $orderId,
                'customer_id'   => $customer->id,
            ]);

            if (! $order || ! $order->canCancel() || ! $order->canInvoice()) {
                throw new Exception(trans('bagisto_graphql::app.admin.response.cancel-error'));
            }
            
            $result = $this->orderRepository->cancel($orderId);

            return [
                'status'    => $result ? true : false,
                'order'     => $this->orderRepository->find($orderId),
                'message'   => $result ? trans('shop::app.customers.account.orders.view.cancel-success', ['name' => 'Order']) : trans('bagisto_graphql::app.admin.response.cancel-error')
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Returns a current customer's orders shipments data.
     *
     * @return \Illuminate\Http\Response
     */
    public function shipments($rootValue, array $args, GraphQLContext $context)
    {
        $params = isset($args['input']) ? $args['input'] : (isset($args['id']) ? $args : []);

        if (bagisto_graphql()->guard($this->guard)->check()) {
            $customer = bagisto_graphql()->guard($this->guard)->user();
            $currentPage = isset($params['page']) ? $params['page'] : 1;

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });
           
            $shipments = app(ShipmentRepository::class)->scopeQuery(function ($query) use ($customer, $params) {
                $qb = $query->distinct()
                    ->addSelect('shipments.*')
                    ->leftJoin('orders', 'shipments.order_id', '=', 'orders.id')
                    ->where('orders.customer_id', $customer->id);

                if (isset($params['id']) && $params['id']) {
                    $qb->where('shipments.id', $params['id']);
                }

                if (isset($params['order_id']) && $params['order_id']) {
                    $qb->where('shipments.order_id', $params['order_id']);
                }

                if (isset($params['carrier_title']) && $params['carrier_title']) {
                    $qb->where('shipments.carrier_title', 'like', '%' . urldecode($params['carrier_title']) . '%');
                }

                if (isset($params['track_number']) && $params['track_number']) {
                    $qb->where('shipments.track_number', $params['track_number']);
                }

                if (isset($params['shipment_date_from']) && isset($params['shipment_date_to'])) {
                    $qb->where('shipments.created_at', '>=', $params['shipment_date_from'])->where('shipments.created_at', '<=', $params['shipment_date_to']);
                }

                if (isset($params['shipment_date']) && $params['shipment_date']) {
                    $qb->where('shipments.created_at', $params['shipment_date']);
                }

                return $qb;
            });
            
            if (isset($args['id'])) {
                $shipments = $shipments->first();

            } else {
                $shipments = $shipments->paginate(isset($params['limit']) ? $params['limit'] : 10);
            }

            if (($shipments && isset($shipments->first()->id)) || isset($shipments->id)) {
                return $shipments;
            } else {
                throw new Exception(trans('bagisto_graphql::app.shop.response.not-found', ['name'   => 'Shipment']));
            }
        } else {
            throw new Exception(trans('bagisto_graphql::app.shop.customer.no-login-customer'));
        }
    }

    /**
     * Returns a current customer's orders invoices data.
     *
     * @return \Illuminate\Http\Response
     */
    public function invoices($rootValue, array $args, GraphQLContext $context)
    {
        $params = isset($args['input']) ? $args['input'] : (isset($args['id']) ? $args : []);

        if (bagisto_graphql()->guard($this->guard)->check()) {
            $customer = bagisto_graphql()->guard($this->guard)->user();

            $currentPage = isset($params['page']) ? $params['page'] : 1;

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });

            $invoices = app(InvoiceRepository::class)->scopeQuery(function ($query) use ($customer, $params) {

                $qb = $query->distinct()
                    ->addSelect('invoices.*')
                    ->leftJoin('orders', 'invoices.order_id', '=', 'orders.id')
                    ->where('orders.customer_id', $customer->id);

                if (isset($params['id']) && $params['id']) {
                    $qb->where('invoices.id', $params['id']);
                }

                if (isset($params['order_id']) && $params['order_id']) {
                    $qb->where('invoices.order_id', $params['order_id']);
                }

                if (isset($params['quantity']) && $params['quantity']) {
                    $qb->where('invoices.total_qty', $params['quantity']);
                }

                if (isset($params['grand_total']) && $params['grand_total']) {
                    $qb->where('invoices.grand_total', $params['grand_total']);
                }

                if (isset($params['base_grand_total']) && $params['base_grand_total']) {
                    $qb->where('invoices.grand_total', $params['base_grand_total']);
                }

                if (isset($params['invoice_date']) && $params['invoice_date']) {
                    $qb->where('invoices.created_at', $params['invoice_date']);
                }

                return $qb;
            });

            if (isset($args['id'])) {
                $invoices = $invoices->first();
            } else {
                $invoices = $invoices->paginate(isset($params['limit']) ? $params['limit'] : 10);
            }

            if (($invoices && isset($invoices->first()->id)) || isset($invoices->id)) {
                return $invoices;
            } else {
                throw new Exception(trans('bagisto_graphql::app.shop.response.not-found', ['name'   => 'Invoice']));
            }
        } else {
            throw new Exception(trans('bagisto_graphql::app.shop.customer.no-login-customer'));
        }
    }

    /**
     * Returns a current customer's orders refunds data.
     *
     * @return \Illuminate\Http\Response
     */
    public function refunds($rootValue, array $args, GraphQLContext $context)
    {

        $params = isset($args['input']) ? $args['input'] : (isset($args['id']) ? $args : []);

        if (bagisto_graphql()->guard($this->guard)->check()) {
            $customer = bagisto_graphql()->guard($this->guard)->user();

            $currentPage = isset($params['page']) ? $params['page'] : 1;

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });

            $invoices = app(RefundRepository::class)->scopeQuery(function ($query) use ($customer, $params) {

                $qb = $query->distinct()
                    ->addSelect('refunds.*')
                    ->leftJoin('orders', 'refunds.order_id', '=', 'orders.id')
                    ->where('orders.customer_id', $customer->id);

                if (isset($params['id']) && $params['id']) {
                    $qb->where('refunds.id', $params['id']);
                }

                if (isset($params['order_id']) && $params['order_id']) {
                    $qb->where('refunds.order_id', $params['order_id']);
                }

                if (isset($params['quantity']) && $params['quantity']) {
                    $qb->where('refunds.total_qty', $params['quantity']);
                }

                if (isset($params['adjustment_refund']) && $params['adjustment_refund']) {
                    $qb->where('refunds.adjustment_refund', $params['adjustment_refund']);
                }

                if (isset($params['adjustment_fee']) && $params['adjustment_fee']) {
                    $qb->where('refunds.adjustment_fee', $params['adjustment_fee']);
                }

                if (isset($params['shipping_amount']) && $params['shipping_amount']) {
                    $qb->where('refunds.shipping_amount', $params['shipping_amount']);
                }

                if (isset($params['tax_amount']) && $params['tax_amount']) {
                    $qb->where('refunds.tax_amount', $params['tax_amount']);
                }

                if (isset($params['discount_amount']) && $params['discount_amount']) {
                    $qb->where('refunds.discount_amount', $params['discount_amount']);
                }

                if (isset($params['grand_total']) && $params['grand_total']) {
                    $qb->where('refunds.grand_total', $params['grand_total']);
                }

                if (isset($params['base_grand_total']) && $params['base_grand_total']) {
                    $qb->where('refunds.grand_total', $params['base_grand_total']);
                }

                if (isset($params['refund_date']) && $params['refund_date']) {
                    $qb->where('refunds.created_at', $params['refund_date']);
                }

                return $qb;
            });

            if (isset($args['id'])) {
                $invoices = $invoices->first();
            } else {
                $invoices = $invoices->paginate(isset($params['limit']) ? $params['limit'] : 10);
            }

            if (($invoices && isset($invoices->first()->id)) || isset($invoices->id)) {
                return $invoices;
            } else {
                throw new Exception(trans('bagisto_graphql::app.shop.response.not-found', ['name'   => 'Refund']));
            }
        } else {
            throw new Exception(trans('bagisto_graphql::app.shop.customer.no-login-customer'));
        }
    }
}
