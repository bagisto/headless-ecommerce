<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\RefundRepository;
use Webkul\Sales\Repositories\ShipmentRepository;

class OrderMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected OrderRepository $orderRepository)
    {
        Auth::setDefaultDriver('api');
    }

    /**
     * Returns a current customer's order detail.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function order($rootValue, array $args, GraphQLContext $context)
    {
        $customer = bagisto_graphql()->authorize();

        $order = $this->orderRepository->findOneWhere([
            'id'          => $args['id'],
            'customer_id' => auth()->user()->id,
        ]);

        if (! empty($order->id)) {
            return $order;
        } else {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.orders.not-found'));
        }
    }

    /**
     * Remove a resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel($rootValue, array $args, GraphQLContext $context)
    {
        $customer = bagisto_graphql()->authorize();

        try {
            $order = $this->orderRepository->findOneWhere([
                'id'          => $args['id'],
                'customer_id' => auth()->user()->id,
            ]);

            if (
                ! $order
                || ! $order->canCancel()
                || ! $order->canInvoice()
            ) {
                throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.orders.cancel-error'));
            }

            $result = $this->orderRepository->cancel($args['id']);

            return [
                'success' => ! empty($result),
                'message' => $result
                    ? trans('bagisto_graphql::app.shop.customers.account.orders.cancel-success')
                    : trans('bagisto_graphql::app.shop.customers.account.orders.cancel-error'),
                'order'   => $this->orderRepository->find($args['id']),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
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

        if (auth()->check()) {
            $currentPage = isset($params['page']) ? $params['page'] : 1;

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });

            $shipments = app(ShipmentRepository::class)->scopeQuery(function ($query) use ($params) {
                return $query->distinct()
                    ->addSelect('shipments.*')
                    ->leftJoin('orders', 'shipments.order_id', '=', 'orders.id')
                    ->where('orders.customer_id', auth()->user()->id)
                    ->when(! empty($params['id']), function ($qb) use ($params) {
                        $qb->where('shipments.id', $params['id']);
                    })
                    ->when(! empty($params['order_id']), function ($qb) use ($params) {
                        $qb->where('shipments.order_id', $params['order_id']);
                    })
                    ->when(! empty($params['carrier_title']), function ($qb) use ($params) {
                        $qb->where('shipments.carrier_title', 'like', '%'.urldecode($params['carrier_title']).'%');
                    })
                    ->when(! empty($params['track_number']), function ($qb) use ($params) {
                        $qb->where('shipments.track_number', $params['track_number']);
                    })
                    ->when(
                        ! empty($params['shipment_date_from'])
                        && ! empty($params['shipment_date_to']),
                        function ($qb) use ($params) {
                            $qb->where('shipments.created_at', '>=', $params['shipment_date_from'])
                                ->where('shipments.created_at', '<=', $params['shipment_date_to']);
                        }
                    )
                    ->when(! empty($params['shipment_date']), function ($qb) use ($params) {
                        $qb->where('shipments.created_at', $params['shipment_date']);
                    });
            });

            if (isset($args['id'])) {
                $shipments = $shipments->first();

            } else {
                $shipments = $shipments->paginate($params['limit'] ?? 10);
            }

            if (
                (
                    $shipments
                    && isset($shipments->first()->id)
                ) || isset($shipments->id)
            ) {
                return $shipments;
            } else {
                throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.orders.shipment.not-found'));
            }
        } else {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.no-login-customer'));
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

        if (auth()->check()) {
            $currentPage = isset($params['page']) ? $params['page'] : 1;

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });

            $invoices = app(InvoiceRepository::class)->scopeQuery(function ($query) use ($params) {
                return $query->distinct()
                    ->addSelect('invoices.*')
                    ->leftJoin('orders', 'invoices.order_id', '=', 'orders.id')
                    ->where('orders.customer_id', auth()->user()->id)
                    ->when(! empty($params['id']), function ($qb) use ($params) {
                        $qb->where('invoices.id', $params['id']);
                    })
                    ->when(! empty($params['order_id']), function ($qb) use ($params) {
                        $qb->where('invoices.order_id', $params['order_id']);
                    })
                    ->when(! empty($params['quantity']), function ($qb) use ($params) {
                        $qb->where('invoices.total_qty', $params['quantity']);
                    })
                    ->when(! empty($params['grand_total']), function ($qb) use ($params) {
                        $qb->where('invoices.grand_total', $params['grand_total']);
                    })
                    ->when(! empty($params['base_grand_total']), function ($qb) use ($params) {
                        $qb->where('invoices.grand_total', $params['base_grand_total']);
                    })
                    ->when(! empty($params['invoice_date']), function ($qb) use ($params) {
                        $qb->where('invoices.created_at', $params['invoice_date']);
                    });
            });

            if (isset($args['id'])) {
                $invoices = $invoices->first();
            } else {
                $invoices = $invoices->paginate($params['limit'] ?? 10);
            }

            if (
                (
                    $invoices
                    && isset($invoices->first()->id)
                ) || isset($invoices->id)
            ) {
                return $invoices;
            } else {
                throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.orders.invoice.not-found'));
            }
        } else {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.no-login-customer'));
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

        if (auth()->check()) {
            $currentPage = isset($params['page']) ? $params['page'] : 1;

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });

            $invoices = app(RefundRepository::class)->scopeQuery(function ($query) use ($params) {
                return $query->distinct()
                    ->addSelect('refunds.*')
                    ->leftJoin('orders', 'refunds.order_id', '=', 'orders.id')
                    ->where('orders.customer_id', auth()->user()->id)
                    ->when(! empty($params['id']), function ($qb) use ($params) {
                        $qb->where('refunds.id', $params['id']);
                    })
                    ->when(! empty($params['order_id']), function ($qb) use ($params) {
                        $qb->where('refunds.order_id', $params['order_id']);
                    })
                    ->when(! empty($params['quantity']), function ($qb) use ($params) {
                        $qb->where('refunds.total_qty', $params['quantity']);
                    })
                    ->when(! empty($params['adjustment_refund']), function ($qb) use ($params) {
                        $qb->where('refunds.adjustment_refund', $params['adjustment_refund']);
                    })
                    ->when(! empty($params['adjustment_fee']), function ($qb) use ($params) {
                        $qb->where('refunds.adjustment_fee', $params['adjustment_fee']);
                    })
                    ->when(! empty($params['shipping_amount']), function ($qb) use ($params) {
                        $qb->where('refunds.shipping_amount', $params['shipping_amount']);
                    })
                    ->when(! empty($params['tax_amount']), function ($qb) use ($params) {
                        $qb->where('refunds.tax_amount', $params['tax_amount']);
                    })
                    ->when(! empty($params['discount_amount']), function ($qb) use ($params) {
                        $qb->where('refunds.discount_amount', $params['discount_amount']);
                    })
                    ->when(! empty($params['grand_total']), function ($qb) use ($params) {
                        $qb->where('refunds.grand_total', $params['grand_total']);
                    })
                    ->when(! empty($params['base_grand_total']), function ($qb) use ($params) {
                        $qb->where('refunds.grand_total', $params['base_grand_total']);
                    })
                    ->when(! empty($params['refund_date']), function ($qb) use ($params) {
                        $qb->where('refunds.created_at', $params['refund_date']);
                    });
            });

            if (isset($args['id'])) {
                $invoices = $invoices->first();
            } else {
                $invoices = $invoices->paginate($params['limit'] ?? 10);
            }

            if (
                (
                    $invoices
                    && isset($invoices->first()->id)
                ) || isset($invoices->id)
            ) {
                return $invoices;
            } else {
                throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.orders.refund.not-found'));
            }
        } else {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.no-login-customer'));
        }
    }
}
