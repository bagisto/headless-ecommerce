<?php

namespace Webkul\GraphQLAPI\Helper;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Webkul\Paypal\Payment\SmartButton;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\OrderRepository;

class PaymentHelper
{
    /**
     * Create a new helper instance.
     *
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected InvoiceRepository $invoiceRepository,
        protected SmartButton $smartButton,
    ) {}

    public function createInvoice($cart, $paymentDetail, $order)
    {
        if ( $order->canInvoice() ) {
            if ( $cart?->payment?->method && $cart->payment->method == 'paypal_smart_button') {
                request()->merge(['orderData' => [
                    'orderID' => $paymentDetail['order_id'],
                ]]);
            } else {
                request()->merge($paymentDetail);
            }

            $this->invoiceRepository->create($this->prepareInvoiceData($order));

            $this->orderRepository->update(['status' => 'processing'], $order->id);
        }
    }

    /**
     * Prepares order's invoice data for creation.
     *
     * @return array
     */
    protected function prepareInvoiceData($order)
    {
        $invoiceData = ['order_id' => $order->id];

        foreach ($order->items as $item) {
            $invoiceData['invoice']['items'][$item->id] = $item->qty_to_invoice;
        }

        return $invoiceData;
    }

    protected function isNewTransaction(string $transactionId): bool
    {
        return ! DB::table('order_transactions')->where('transaction_id', $transactionId)->exists();
    }

    protected function checkPaypalPaymentStatus($paymentId)
    {
        $clientId = core()->getConfigData('sales.payment_methods.paypal_standard.client_id');
        $secretKey = core()->getConfigData('sales.payment_methods.paypal_standard.client_secret');
        $sandbox = core()->getConfigData('sales.payment_methods.paypal_standard.sandbox');

        $url = $sandbox
            ? "https://api-m.sandbox.paypal.com/v1/payments/payment/{$paymentId}"
            : "https://api-m.paypal.com/v1/payments/payment/{$paymentId}";

        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FAILONERROR    => true,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Authorization: Basic '.base64_encode("{$clientId}:{$secretKey}"),
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response) {
            $responseData = json_decode($response, true);

            return $responseData['state'] ?? '' === 'approved';
        }

        return false;
    }

    public function checkSmartButtonPaymentStatus(string $orderId): bool
    {
        $transactionDetails = json_decode(json_encode($this->smartButton->getOrder($orderId)), true);

        return $transactionDetails['statusCode'] ?? 0 === 200;
    }

    /**
     * Verify payment.
     */
    public function isPaymentSuccessful(array $args, $cart): bool
    {
        $isPaymentComplete =  match ($args['payment_method']) {
            'paypal_standard' =>
                ! empty($args['txn_id'])
                && $this->isNewTransaction($args['txn_id'])
                && $this->checkPaypalPaymentStatus($args['txn_id']),

            'paypal_smart_button' =>
                ! empty($args['order_id'])
                && $this->isNewTransaction($args['order_id'])
                && $this->checkSmartButtonPaymentStatus($args['order_id']),

            'cashondelivery' => true,

            'moneytransfer'  => true,

            default => null,
        };

        if ($isPaymentComplete !== null) {
            return $isPaymentComplete;
        }

        $eventData = [
            'payment_method' => $args['payment_method'],
            'args'           => $args,
            'cart'           => $cart,
            'status'         => false, // 👈 listener will update this
        ];

        Event::dispatch('checkout.order.payment.verify', $eventData);

        return (bool) $eventData['status'];
    }
}
