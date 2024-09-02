<?php

namespace Webkul\GraphQLAPI\Queries\Sales;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FormattedPrice extends BaseFilter
{
    /**
     * Get formatted price for Order.
     */
    public function getOrderPriceData(object $order): array
    {
        return $this->getFormattedPrice($order, $order->order_currency_code);
    }

    /**
     * Get formatted price for OrderItem.
     */
    public function getOrderItemPriceData(object $orderItem): array
    {
        return $this->getFormattedPrice($orderItem, $orderItem->order->order_currency_code);
    }

    /**
     * Get formatted price for Invoice.
     */
    public function getInvoicePriceData(object $invoice): array
    {
        return $this->getFormattedPrice($invoice, $invoice->order_currency_code);
    }

    /**
     * Get formatted price for Invoice Item.
     */
    public function getInvoiceItemPriceData(object $invoiceItem): array
    {
        return $this->getFormattedPrice($invoiceItem, $invoiceItem->invoice->order_currency_code);
    }

    /**
     * Get formatted price for Shipment Item.
     */
    public function getShipmentItemPriceData(object $shipmentItem): array
    {
        return $this->getFormattedPrice($shipmentItem, $shipmentItem->shipment->order->order_currency_code);
    }

    /**
     * Get formatted price for Refund.
     */
    public function getRefundPriceData(object $refund): array
    {
        return $this->getFormattedPrice($refund, $refund->order_currency_code);
    }

    /**
     * Get formatted price for Refund Item.
     */
    public function getRefundItemPriceData(object $refundItem): array
    {
        return $this->getFormattedPrice($refundItem, $refundItem->refund->order_currency_code);
    }
}
