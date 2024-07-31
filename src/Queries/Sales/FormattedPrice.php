<?php

namespace Webkul\GraphQLAPI\Queries\Sales;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Queries\BaseFilter;
use Webkul\Sales\Repositories\InvoiceItemRepository;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\OrderItemRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\RefundItemRepository;
use Webkul\Sales\Repositories\RefundRepository;
use Webkul\Sales\Repositories\ShipmentItemRepository;

class FormattedPrice extends BaseFilter
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected OrderItemRepository $orderItemRepository,
        protected InvoiceRepository $invoiceRepository,
        protected InvoiceItemRepository $invoiceItemRepository,
        protected ShipmentItemRepository $shipmentItemRepository,
        protected RefundRepository $refundRepository,
        protected RefundItemRepository $refundItemRepository
    ) {}

    /**
     * Get formatted price for Order data.
     *
     * @param  mixed  $rootValue
     * @return mixed
     */
    public function getOrderPriceData($rootValue, array $args, GraphQLContext $context)
    {
        $order = $this->orderRepository->find($rootValue->id);

        $orderCurrencyCode = $order->order_currency_code;

        return [
            'grand_total'                   => core()->formatPrice($order->grand_total, $orderCurrencyCode),
            'base_grand_total'              => core()->formatBasePrice($order->base_grand_total),
            'grand_total_invoiced'          => core()->formatPrice($order->grand_total_invoiced, $orderCurrencyCode),
            'base_grand_total_invoiced'     => core()->formatBasePrice($order->base_grand_total_invoiced),
            'grand_total_refunded'          => core()->formatPrice($order->grand_total_refunded, $orderCurrencyCode),
            'base_grand_total_refunded'     => core()->formatBasePrice($order->base_grand_total_refunded),
            'sub_total'                     => core()->formatPrice($order->sub_total, $orderCurrencyCode),
            'base_sub_total'                => core()->formatBasePrice($order->base_sub_total),
            'sub_total_invoiced'            => core()->formatPrice($order->sub_total_invoiced, $orderCurrencyCode),
            'base_sub_total_invoiced'       => core()->formatBasePrice($order->base_sub_total_invoiced),
            'sub_total_refunded'            => core()->formatPrice($order->sub_total_refunded, $orderCurrencyCode),
            'discount_amount'               => core()->formatPrice($order->discount_amount, $orderCurrencyCode),
            'base_discount_amount'          => core()->formatBasePrice($order->base_discount_amount),
            'discount_invoiced'             => core()->formatPrice($order->discount_invoiced, $orderCurrencyCode),
            'base_discount_invoiced'        => core()->formatBasePrice($order->base_discount_invoiced),
            'discount_refunded'             => core()->formatPrice($order->discount_refunded, $orderCurrencyCode),
            'base_discount_refunded'        => core()->formatBasePrice($order->base_discount_refunded),
            'tax_amount'                    => core()->formatPrice($order->tax_amount, $orderCurrencyCode),
            'base_tax_amount'               => core()->formatBasePrice($order->base_tax_amount),
            'tax_amount_invoiced'           => core()->formatPrice($order->tax_amount_invoiced, $orderCurrencyCode),
            'base_tax_amount_invoiced'      => core()->formatBasePrice($order->base_tax_amount_invoiced),
            'tax_amount_refunded'           => core()->formatPrice($order->tax_amount_refunded, $orderCurrencyCode),
            'base_tax_amount_refunded'      => core()->formatBasePrice($order->base_tax_amount_refunded),
            'shipping_amount'               => core()->formatPrice($order->shipping_amount, $orderCurrencyCode),
            'base_shipping_amount'          => core()->formatBasePrice($order->base_shipping_amount),
            'shipping_invoiced'             => core()->formatPrice($order->shipping_invoiced, $orderCurrencyCode),
            'base_shipping_invoiced'        => core()->formatBasePrice($order->base_shipping_invoiced),
            'shipping_refunded'             => core()->formatPrice($order->shipping_refunded, $orderCurrencyCode),
            'base_shipping_refunded'        => core()->formatBasePrice($order->base_shipping_refunded),
            'shipping_discount_amount'      => core()->formatPrice($order->shipping_discount_amount, $orderCurrencyCode),
            'base_shipping_discount_amount' => core()->formatBasePrice($order->base_shipping_discount_amount),
            'shipping_tax_amount'           => core()->formatPrice($order->shipping_tax_amount, $orderCurrencyCode),
            'base_shipping_tax_amount'      => core()->formatBasePrice($order->base_shipping_tax_amount),
            'shipping_tax_refunded'         => core()->formatPrice($order->shipping_tax_refunded, $orderCurrencyCode),
            'base_shipping_tax_refunded'    => core()->formatBasePrice($order->base_shipping_tax_refunded),
            'sub_total_incl_tax'            => core()->formatPrice($order->sub_total_incl_tax, $orderCurrencyCode),
            'base_sub_total_incl_tax'       => core()->formatBasePrice($order->base_sub_total_incl_tax),
            'shipping_amount_incl_tax'      => core()->formatPrice($order->shipping_amount_incl_tax, $orderCurrencyCode),
            'base_shipping_amount_incl_tax' => core()->formatBasePrice($order->base_shipping_amount_incl_tax),
        ];
    }

    /**
     * Get formatted price for OrderItem data.
     *
     * @param  mixed  $rootValue
     * @return mixed
     */
    public function getOrderItemPriceData($rootValue, array $args, GraphQLContext $context)
    {
        $orderItem = $this->orderItemRepository->find($rootValue->id);

        $orderCurrencyCode = $orderItem->order->order_currency_code;

        return [
            'price'                    => core()->formatPrice($orderItem->price, $orderCurrencyCode),
            'base_price'               => core()->formatBasePrice($orderItem->base_price),
            'total'                    => core()->formatPrice($orderItem->total, $orderCurrencyCode),
            'base_total'               => core()->formatBasePrice($orderItem->base_total),
            'total_invoiced'           => core()->formatPrice($orderItem->total_invoiced, $orderCurrencyCode),
            'base_total_invoiced'      => core()->formatBasePrice($orderItem->base_total_invoiced),
            'amount_refunded'          => core()->formatPrice($orderItem->amount_refunded, $orderCurrencyCode),
            'base_amount_refunded'     => core()->formatBasePrice($orderItem->base_amount_refunded),
            'discount_amount'          => core()->formatPrice($orderItem->discount_amount, $orderCurrencyCode),
            'base_discount_amount'     => core()->formatBasePrice($orderItem->base_discount_amount),
            'discount_invoiced'        => core()->formatPrice($orderItem->discount_invoiced, $orderCurrencyCode),
            'base_discount_invoiced'   => core()->formatBasePrice($orderItem->base_discount_invoiced),
            'discount_refunded'        => core()->formatPrice($orderItem->discount_refunded, $orderCurrencyCode),
            'base_discount_refunded'   => core()->formatBasePrice($orderItem->base_discount_refunded),
            'tax_amount'               => core()->formatPrice($orderItem->tax_amount, $orderCurrencyCode),
            'base_tax_amount'          => core()->formatBasePrice($orderItem->base_tax_amount),
            'tax_amount_invoiced'      => core()->formatPrice($orderItem->tax_amount_invoiced, $orderCurrencyCode),
            'base_tax_amount_invoiced' => core()->formatBasePrice($orderItem->base_tax_amount_invoiced),
            'tax_amount_refunded'      => core()->formatPrice($orderItem->tax_amount_refunded, $orderCurrencyCode),
            'base_tax_amount_refunded' => core()->formatBasePrice($orderItem->base_tax_amount_refunded),
            'grant_total'              => core()->formatPrice($orderItem->total + $orderItem->tax_amount, $orderCurrencyCode),
            'base_grant_total'         => core()->formatPrice($orderItem->base_total + $orderItem->base_tax_amount, $orderCurrencyCode),
            'price_incl_tax'           => core()->formatPrice($orderItem->price_incl_tax, $orderCurrencyCode),
            'base_price_incl_tax'      => core()->formatBasePrice($orderItem->base_price_incl_tax),
            'total_incl_tax'           => core()->formatPrice($orderItem->total_incl_tax, $orderCurrencyCode),
            'base_total_incl_tax'      => core()->formatBasePrice($orderItem->base_total_incl_tax),
        ];
    }

    /**
     * Get formatted price for Invoice data.
     *
     * @param  mixed  $rootValue
     * @return mixed
     */
    public function getInvoicePriceData($rootValue, array $args, GraphQLContext $context)
    {
        $invoice = $this->invoiceRepository->find($rootValue->id);

        $orderCurrencyCode = $invoice->order_currency_code;

        return [
            'sub_total'                     => core()->formatPrice($invoice->sub_total, $orderCurrencyCode),
            'base_sub_total'                => core()->formatBasePrice($invoice->base_sub_total),
            'grand_total'                   => core()->formatPrice($invoice->grand_total, $orderCurrencyCode),
            'base_grand_total'              => core()->formatBasePrice($invoice->base_grand_total),
            'shipping_amount'               => core()->formatPrice($invoice->shipping_amount, $orderCurrencyCode),
            'base_shipping_amount'          => core()->formatBasePrice($invoice->base_shipping_amount),
            'tax_amount'                    => core()->formatPrice($invoice->tax_amount, $orderCurrencyCode),
            'base_tax_amount'               => core()->formatBasePrice($invoice->base_tax_amount),
            'discount_amount'               => core()->formatPrice($invoice->discount_amount, $orderCurrencyCode),
            'base_discount_amount'          => core()->formatBasePrice($invoice->base_discount_amount),
            'shipping_tax_amount'           => core()->formatPrice($invoice->shipping_tax_amount, $orderCurrencyCode),
            'base_shipping_tax_amount'      => core()->formatBasePrice($invoice->base_shipping_tax_amount),
            'sub_total_incl_tax'            => core()->formatPrice($invoice->sub_total_incl_tax, $orderCurrencyCode),
            'base_sub_total_incl_tax'       => core()->formatBasePrice($invoice->base_sub_total_incl_tax),
            'shipping_amount_incl_tax'      => core()->formatPrice($invoice->shipping_amount_incl_tax, $orderCurrencyCode),
            'base_shipping_amount_incl_tax' => core()->formatBasePrice($invoice->base_shipping_amount_incl_tax),
        ];
    }

    /**
     * Get formatted price for Invoice Item data.
     *
     * @param  mixed  $rootValue
     * @return mixed
     */
    public function getInvoiceItemPriceData($rootValue, array $args, GraphQLContext $context)
    {
        $invoiceItem = $this->invoiceItemRepository->find($rootValue->id);

        $orderCurrencyCode = $invoiceItem->invoice->order_currency_code;

        return [
            'price'               => core()->formatPrice($invoiceItem->price, $orderCurrencyCode),
            'base_price'          => core()->formatBasePrice($invoiceItem->base_price),
            'total'               => core()->formatPrice($invoiceItem->total, $orderCurrencyCode),
            'base_total'          => core()->formatBasePrice($invoiceItem->base_total),
            'tax_amount'          => core()->formatPrice($invoiceItem->tax_amount, $orderCurrencyCode),
            'base_tax_amount'     => core()->formatBasePrice($invoiceItem->base_tax_amount),
            'grand_total'         => core()->formatPrice($invoiceItem->total + $invoiceItem->tax_amount, $orderCurrencyCode),
            'base_grand_total'    => core()->formatBasePrice($invoiceItem->base_total + $invoiceItem->base_tax_amount),
            'price_incl_tax'      => core()->formatPrice($invoiceItem->price_incl_tax, $orderCurrencyCode),
            'base_price_incl_tax' => core()->formatBasePrice($invoiceItem->base_price_incl_tax),
            'total_incl_tax'      => core()->formatPrice($invoiceItem->total_incl_tax, $orderCurrencyCode),
            'base_total_incl_tax' => core()->formatBasePrice($invoiceItem->base_total_incl_tax),
        ];
    }

    /**
     * Get formatted price for Shipment Item data.
     *
     * @param  mixed  $rootValue
     * @return mixed
     */
    public function getShipmentItemPriceData($rootValue, array $args, GraphQLContext $context)
    {
        $shipmentItem = $this->shipmentItemRepository->find($rootValue->id);

        $orderCurrencyCode = $shipmentItem->shipment->order->order_currency_code;

        return [
            'price'               => core()->formatPrice($shipmentItem->price, $orderCurrencyCode),
            'base_price'          => core()->formatBasePrice($shipmentItem->base_price),
            'total'               => core()->formatPrice($shipmentItem->total, $orderCurrencyCode),
            'base_total'          => core()->formatBasePrice($shipmentItem->base_total),
            'price_incl_tax'      => core()->formatPrice($shipmentItem->price_incl_tax, $orderCurrencyCode),
            'base_price_incl_tax' => core()->formatBasePrice($shipmentItem->base_price_incl_tax),
        ];
    }

    /**
     * Get formatted price for Refund data.
     *
     * @param  mixed  $rootValue
     * @return mixed
     */
    public function getRefundPriceData($rootValue, array $args, GraphQLContext $context)
    {
        $refund = $this->refundRepository->find($rootValue->id);

        $orderCurrencyCode = $refund->order->order_currency_code;

        return [
            'sub_total'                     => core()->formatPrice($refund->sub_total, $orderCurrencyCode),
            'base_sub_total'                => core()->formatBasePrice($refund->base_sub_total),
            'grand_total'                   => core()->formatPrice($refund->grand_total, $orderCurrencyCode),
            'base_grand_total'              => core()->formatBasePrice($refund->base_grand_total),
            'adjustment_refund'             => core()->formatPrice($refund->adjustment_refund, $orderCurrencyCode),
            'base_adjustment_refund'        => core()->formatBasePrice($refund->base_adjustment_refund),
            'adjustment_fee'                => core()->formatPrice($refund->adjustment_fee, $orderCurrencyCode),
            'base_adjustment_fee'           => core()->formatBasePrice($refund->base_adjustment_fee),
            'shipping_amount'               => core()->formatPrice($refund->shipping_amount, $orderCurrencyCode),
            'base_shipping_amount'          => core()->formatBasePrice($refund->base_shipping_amount),
            'tax_amount'                    => core()->formatPrice($refund->tax_amount, $orderCurrencyCode),
            'base_tax_amount'               => core()->formatBasePrice($refund->base_tax_amount),
            'discount_amount'               => core()->formatPrice($refund->discount_amount, $orderCurrencyCode),
            'base_discount_amount'          => core()->formatBasePrice($refund->base_discount_amount),
            'shipping_tax_amount'           => core()->formatPrice($refund->shipping_tax_amount, $orderCurrencyCode),
            'base_shipping_tax_amount'      => core()->formatBasePrice($refund->base_shipping_tax_amount),
            'sub_total_incl_tax'            => core()->formatPrice($refund->sub_total_incl_tax, $orderCurrencyCode),
            'base_sub_total_incl_tax'       => core()->formatBasePrice($refund->base_sub_total_incl_tax),
            'shipping_amount_incl_tax'      => core()->formatPrice($refund->shipping_amount_incl_tax, $orderCurrencyCode),
            'base_shipping_amount_incl_tax' => core()->formatBasePrice($refund->base_shipping_amount_incl_tax),
        ];
    }

    /**
     * Get formatted price for Refund Item data.
     *
     * @param  mixed  $rootValue
     * @return mixed
     */
    public function getRefundItemPriceData($rootValue, array $args, GraphQLContext $context)
    {
        $refundItem = $this->refundItemRepository->find($rootValue->id);

        $orderCurrencyCode = $refundItem->refund->order->order_currency_code;

        return [
            'price'                => core()->formatPrice($refundItem->price, $orderCurrencyCode),
            'base_price'           => core()->formatBasePrice($refundItem->base_price),
            'total'                => core()->formatPrice($refundItem->total, $orderCurrencyCode),
            'base_total'           => core()->formatBasePrice($refundItem->base_total),
            'tax_amount'           => core()->formatPrice($refundItem->tax_amount, $orderCurrencyCode),
            'base_tax_amount'      => core()->formatBasePrice($refundItem->base_tax_amount),
            'discount_amount'      => core()->formatPrice($refundItem->discount_amount, $orderCurrencyCode),
            'base_discount_amount' => core()->formatBasePrice($refundItem->base_discount_amount),
            'price_incl_tax'       => core()->formatPrice($refundItem->price_incl_tax, $orderCurrencyCode),
            'base_price_incl_tax'  => core()->formatBasePrice($refundItem->base_price_incl_tax),
            'total_incl_tax'       => core()->formatPrice($refundItem->total_incl_tax, $orderCurrencyCode),
            'base_total_incl_tax'  => core()->formatBasePrice($refundItem->base_total_incl_tax),
        ];
    }
}
