<?php

namespace Webkul\GraphQLAPI\Helper;

use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\InvoiceRepository;

class PaymentHelper
{
    /**
     * Create a new helper instance.
     *
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected InvoiceRepository $invoiceRepository
    ) {}

    public function createInvoice($cart, $paymentDetail, $order)
    {
        if (
            ! empty($paymentDetail['error'])
            || $paymentDetail['message'] != "Success"
            || $cart->payment->method != $paymentDetail['payment_method']
        ) {
            return;
        }

        $paymentMethod = $cart->payment->method;

        $paymentIsCompleted = false;

        if (
            $paymentMethod == 'paypal_standard'
            || $paymentMethod == 'paypal_smart_button'
        ) {
            $paymentIsCompleted = $this->checkPaypalPaymentStatus($paymentDetail['transaction_id']);
        }
        
        if ($paymentIsCompleted) {
            $this->orderRepository->update(['status' => 'processing'], $order->id);

            if ($order->canInvoice()) {
                $invoice = $this->invoiceRepository->create($this->prepareInvoiceData($order));
            }
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

    private function checkPaypalPaymentStatus($paymentId)
    {
        $clientId = core()->getConfigData('sales.payment_methods.paypal_standard.client_id');
        $secretKey = core()->getConfigData('sales.payment_methods.paypal_standard.client_secret');

        if (core()->getConfigData('sales.payment_methods.paypal_standard.sandbox')) {
            $url = "https://api-m.sandbox.paypal.com/v1/payments/payment/{$paymentId}";
        } else {
            $url = "https://api-m.paypal.com/v1/payments/payment/{$paymentId}";
        }

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode("{$clientId}:{$secretKey}"),
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            throw new \Exception('Curl error: ' . curl_error($curl));
        }
        curl_close($curl);

        $responseData = json_decode($response, true);
        
        if (isset($responseData['state']) && $responseData['state'] == 'approved') {
            return true;
        }

        return false;
    }
}