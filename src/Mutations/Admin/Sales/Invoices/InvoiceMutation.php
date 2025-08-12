<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Sales\Invoices;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\OrderTransactionRepository;

class InvoiceMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected InvoiceRepository $invoiceRepository,
        protected OrderTransactionRepository $orderTransactionRepository,
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

            if (! $this->invoiceRepository->isValidQuantity($invoice)) {
                throw new CustomException(trans('bagisto_graphql::app.admin.sales.invoices.invalid-qty'));
            }

            $invoice = $this->invoiceRepository->create(array_merge($invoice, [
                'order_id' => $args['order_id'],
            ]));

            if ($args['can_create_transaction']) {
                $this->createTransaction($invoice);
            }

            return [
                'success'  => true,
                'message'  => trans('bagisto_graphql::app.admin.sales.invoices.create-success'),
                'invoice'  => $invoice,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Create transaction for the invoice.
     */
    private function createTransaction(object $invoice): void
    {
        $transactionId = md5(uniqid());

        $transactionData = [
            'transaction_id' => $transactionId,
            'status'         => $invoice->state,
            'type'           => $invoice->order->payment->method,
            'payment_method' => $invoice->order->payment->method,
            'order_id'       => $invoice->order->id,
            'invoice_id'     => $invoice->id,
            'amount'         => $invoice->grand_total,
        ];

        $this->orderTransactionRepository->create($transactionData);
    }
}
