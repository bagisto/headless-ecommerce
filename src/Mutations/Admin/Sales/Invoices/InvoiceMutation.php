<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Sales\Invoices;

use Exception;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\GraphQLAPI\Validators\Admin\CustomException;

class InvoiceMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Sales\Repositories\OrderRepository  $orderRepository
     * @param  \Webkul\Sales\Repositories\InvoiceRepository  $invoiceRepository
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected InvoiceRepository $invoiceRepository
    ) {
    }

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

        if (! $order->canInvoice()) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.invoices.creation-error'));
        }

        try {
            if (empty($params['invoice_data'])) {
                throw new CustomException(trans('bagisto_graphql::app.admin.sales.invoices.product-error'));
            }

            $invoiceData = [];

            foreach ($params['invoice_data'] as $data) {
                $invoiceData = $invoiceData + [
                    $data['order_item_id'] => $data['quantity'],
                ];
            }

            $invoice['invoice']['items'] = $invoiceData;

            $haveProductToInvoice = false;

            foreach ($invoice['invoice']['items'] as $qty) {
                if ($qty) {
                    $haveProductToInvoice = true;

                    break;
                }
            }

            if (! $haveProductToInvoice) {
                throw new CustomException(trans('bagisto_graphql::app.admin.sales.invoices.product-error'));
            }

            $invoicedData = $this->invoiceRepository->create(array_merge($invoice, ['order_id' => $orderId]));

            return $invoicedData;
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
