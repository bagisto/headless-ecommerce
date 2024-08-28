<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Sales\Invoices;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\OrderRepository;

class InvoiceMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected InvoiceRepository $invoiceRepository
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

        if (! $order->canInvoice()) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.invoices.creation-error'));
        }

        try {
            if (empty($args['invoice_data'])) {
                throw new CustomException(trans('bagisto_graphql::app.admin.sales.invoices.product-error'));
            }

            $invoiceData = [];

            foreach ($args['invoice_data'] as $arg) {
                $invoiceData = $invoiceData + [
                    $arg['order_item_id'] => $arg['quantity'],
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

            $invoice = $this->invoiceRepository->create(array_merge($invoice, [
                'order_id'               => $args['order_id'],
                'can_create_transaction' => (int) $args['can_create_transaction'],
            ]));

            return [
                'success'  => true,
                'message'  => trans('bagisto_graphql::app.admin.sales.invoices.create-success'),
                'invoice'  => $invoice,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
