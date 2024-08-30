<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Sales\Transactions;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Payment\Facades\Payment;
use Webkul\Sales\Models\Invoice;
use Webkul\Sales\Models\Order;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\OrderTransactionRepository;
use Webkul\Sales\Repositories\ShipmentRepository;

class TransactionMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected InvoiceRepository $invoiceRepository,
        protected ShipmentRepository $shipmentRepository,
        protected OrderTransactionRepository $orderTransactionRepository
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
        $paymentMethods = collect(Payment::getPaymentMethods())->pluck('method')->toArray();

        bagisto_graphql()->validate($args, [
            'invoice_id'     => 'required',
            'payment_method' => 'required|in:'.implode(',', $paymentMethods),
            'amount'         => 'required|numeric',
        ]);

        $invoice = $this->invoiceRepository->find($args['invoice_id']);

        if (! $invoice) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.invoices.not-found'));
        }

        $transactionAmtBefore = $this->orderTransactionRepository
            ->where('invoice_id', $invoice->id)
            ->sum('amount');

        $transactionAmtFinal = $args['amount'] + $transactionAmtBefore;

        if ($invoice->state == 'paid') {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.transactions.already-paid'));
        }

        if ($transactionAmtFinal > $invoice->base_grand_total) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.transactions.amount-exceed'));
        }

        if ($args['amount'] <= 0) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.transactions.zero-amount'));
        }

        $order = $this->orderRepository->find($invoice->order_id);

        $transaction = $this->orderTransactionRepository->create([
            'transaction_id' => bin2hex(random_bytes(20)),
            'type'           => $args['payment_method'],
            'payment_method' => $args['payment_method'],
            'invoice_id'     => $invoice->id,
            'order_id'       => $invoice->order_id,
            'amount'         => $args['amount'],
            'status'         => 'paid',
            'data'           => json_encode([
                'paidAmount' => $args['amount'],
            ]),
        ]);

        $transactionTotal = $this->orderTransactionRepository
            ->where('invoice_id', $invoice->id)
            ->sum('amount');

        if ($transactionTotal >= $invoice->base_grand_total) {
            $shipments = $this->shipmentRepository->findOneByField('order_id', $invoice->order_id);

            $status = isset($shipments)
                ? Order::STATUS_COMPLETED
                : Order::STATUS_PROCESSING;

            $this->orderRepository->updateOrderStatus($order, $status);

            $this->invoiceRepository->updateState($invoice, Invoice::STATUS_PAID);
        }

        return [
            'success'     => true,
            'message'     => trans('bagisto_graphql::app.admin.sales.transactions.zero-amount'),
            'transaction' => $transaction,
        ];
    }
}
