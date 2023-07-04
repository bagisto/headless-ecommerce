<?php

namespace Webkul\GraphQLAPI\Queries\Sales;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Queries\BaseFilter;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\OrderItemRepository;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\InvoiceItemRepository;
use Webkul\Sales\Repositories\ShipmentItemRepository;
use Webkul\Sales\Repositories\RefundRepository;
use Webkul\Sales\Repositories\RefundItemRepository;

class FormattedPrice extends BaseFilter
{
    /**
     * Order repository instance.
     *
     * @var \Webkul\Sales\Repositories\OrderRepository
     */
    protected $orderRepository;

    /**
     * OrderItem repository instance.
     *
     * @var \Webkul\Sales\Repositories\OrderItemRepository
     */
    protected $orderItemRepository;

    /**
     * Invoice repository instance.
     *
     * @var \Webkul\Sales\Repositories\InvoiceRepository
     */
    protected $invoiceRepository;

    /**
     * InvoiceItem repository instance.
     *
     * @var \Webkul\Sales\Repositories\InvoiceItemRepository
     */
    protected $invoiceItemRepository;

    /**
     * ShipementItem repository instance.
     *
     * @var \Webkul\Sales\Repositories\ShipmentItemRepository
     */
    protected $shipmentItemRepository;

    /**
     * Refund repository instance.
     *
     * @var \Webkul\Sales\Repositories\RefundRepository
     */
    protected $refundRepository;

    /**
     * RefundItem repository instance.
     *
     * @var \Webkul\Sales\Repositories\RefundItemRepository
     */
    protected $refundItemRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Sales\Repositories\OrderRepository  $orderRepository
     * @param  \Webkul\Sales\Repositories\OrderItemRepository  $orderItemRepository
     * @param  \Webkul\Sales\Repositories\InvoiceRepository  $invoiceRepository
     * @param  \Webkul\Sales\Repositories\InvoiceItemRepository  $invoiceItemRepository
     * @param  \Webkul\Sales\Repositories\ShipmentItemRepository  $shipmentItemRepository
     * @param  \Webkul\Sales\Repositories\RefundRepository  $refundRepository
     * @param  \Webkul\Sales\Repositories\RefundItemRepository  $refundItemRepository
     * @return void
     */
    public function __construct(
        OrderRepository $orderRepository,
        OrderItemRepository $orderItemRepository,
        InvoiceRepository $invoiceRepository,
        InvoiceItemRepository $invoiceItemRepository,
        ShipmentItemRepository $shipmentItemRepository,
        RefundRepository $refundRepository,
        RefundItemRepository $refundItemRepository
    ) {
        $this->orderRepository = $orderRepository;

        $this->orderItemRepository = $orderItemRepository;

        $this->invoiceRepository = $invoiceRepository;

        $this->invoiceItemRepository = $invoiceItemRepository;

        $this->shipmentItemRepository = $shipmentItemRepository;

        $this->refundRepository = $refundRepository;

        $this->refundItemRepository = $refundItemRepository;

        $this->_config = request('_config');
    }

    /**
     * Get formatted price for Order data.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return mixed
     */
    public function getOrderPriceData($rootValue, array $args, GraphQLContext $context)
    {
        $order = $this->orderRepository->find($rootValue->id);

        return [
            'grand_total' => core()->formatPrice($order->grand_total, $order->order_currency_code),
            'base_grand_total' => core()->formatBasePrice($order->base_grand_total),
            'grand_total_invoiced' => core()->formatPrice($order->grand_total_invoiced, $order->order_currency_code),
            'base_grand_total_invoiced' => core()->formatBasePrice($order->base_grand_total_invoiced),
            'grand_total_refunded' => core()->formatPrice($order->grand_total_refunded, $order->order_currency_code),
            'base_grand_total_refunded' => core()->formatBasePrice($order->base_grand_total_refunded),
            'sub_total' => core()->formatPrice($order->sub_total, $order->order_currency_code),
            'base_sub_total' => core()->formatBasePrice($order->base_sub_total),
            'sub_total_invoiced' => core()->formatPrice($order->sub_total_invoiced, $order->order_currency_code),
            'base_sub_total_invoiced' => core()->formatBasePrice($order->base_sub_total_invoiced),
            'sub_total_refunded' => core()->formatPrice($order->sub_total_refunded, $order->order_currency_code),
            'discount_amount' => core()->formatPrice($order->discount_amount, $order->order_currency_code),
            'base_discount_amount' => core()->formatBasePrice($order->base_discount_amount),
            'discount_invoiced' => core()->formatPrice($order->discount_invoiced, $order->order_currency_code),
            'base_discount_invoiced' => core()->formatBasePrice($order->base_discount_invoiced),
            'discount_refunded' => core()->formatPrice($order->discount_refunded, $order->order_currency_code),
            'base_discount_refunded' => core()->formatBasePrice($order->base_discount_refunded),
            'tax_amount' => core()->formatPrice($order->tax_amount, $order->order_currency_code),
            'base_tax_amount' => core()->formatBasePrice($order->base_tax_amount),
            'tax_amount_invoiced' => core()->formatPrice($order->tax_amount_invoiced, $order->order_currency_code),
            'base_tax_amount_invoiced' => core()->formatBasePrice($order->base_tax_amount_invoiced),
            'tax_amount_refunded' => core()->formatPrice($order->tax_amount_refunded, $order->order_currency_code),
            'base_tax_amount_refunded' => core()->formatBasePrice($order->base_tax_amount_refunded),
            'shipping_amount' => core()->formatPrice($order->shipping_amount, $order->order_currency_code),
            'base_shipping_amount' => core()->formatBasePrice($order->base_shipping_amount),
            'shipping_invoiced' => core()->formatPrice($order->shipping_invoiced, $order->order_currency_code),
            'base_shipping_invoiced' => core()->formatBasePrice($order->base_shipping_invoiced),
            'shipping_refunded' => core()->formatPrice($order->shipping_refunded, $order->order_currency_code),
            'base_shipping_refunded' => core()->formatBasePrice($order->base_shipping_refunded),
        ];
    }

    /**
     * Get formatted price for OrderItem data.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return mixed
     */
    public function getOrderItemPriceData($rootValue, array $args, GraphQLContext $context)
    {
        $orderItem = $this->orderItemRepository->find($rootValue->id);
        $order = $orderItem->order;

        return  [
            'price' => core()->formatPrice($orderItem->price, $order->order_currency_code),
            'base_price' => core()->formatBasePrice($orderItem->base_price),
            'total' => core()->formatPrice($orderItem->total, $order->order_currency_code),
            'base_total' => core()->formatBasePrice($orderItem->base_total),
            'total_invoiced' => core()->formatPrice($orderItem->total_invoiced, $order->order_currency_code),
            'base_total_invoiced' => core()->formatBasePrice($orderItem->base_total_invoiced),
            'amount_refunded' => core()->formatPrice($orderItem->amount_refunded, $order->order_currency_code),
            'base_amount_refunded' => core()->formatBasePrice($orderItem->base_amount_refunded),
            'discount_amount' => core()->formatPrice($orderItem->discount_amount, $order->order_currency_code),
            'base_discount_amount' => core()->formatBasePrice($orderItem->base_discount_amount),
            'discount_invoiced' => core()->formatPrice($orderItem->discount_invoiced, $order->order_currency_code),
            'base_discount_invoiced' => core()->formatBasePrice($orderItem->base_discount_invoiced),
            'discount_refunded' => core()->formatPrice($orderItem->discount_refunded, $order->order_currency_code),
            'base_discount_refunded' => core()->formatBasePrice($orderItem->base_discount_refunded),
            'tax_amount' => core()->formatPrice($orderItem->tax_amount, $order->order_currency_code),
            'base_tax_amount' => core()->formatBasePrice($orderItem->base_tax_amount),
            'tax_amount_invoiced' => core()->formatPrice($orderItem->tax_amount_invoiced, $order->order_currency_code),
            'base_tax_amount_invoiced' => core()->formatBasePrice($orderItem->base_tax_amount_invoiced),
            'tax_amount_refunded' => core()->formatPrice($orderItem->tax_amount_refunded, $order->order_currency_code),
            'base_tax_amount_refunded' => core()->formatBasePrice($orderItem->base_tax_amount_refunded),
            'grant_total' => core()->formatPrice($orderItem->total + $orderItem->tax_amount, $order->order_currency_code),
            'base_grant_total' => core()->formatPrice($orderItem->base_total + $orderItem->base_tax_amount, $order->order_currency_code),
        ];
    }

    /**
     * Get formatted price for Invoice data.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return mixed
     */
    public function getInvoicePriceData($rootValue, array $args, GraphQLContext $context)
    {
        $invoice = $this->invoiceRepository->find($rootValue->id);
        
        return  [
            'sub_total' => core()->formatPrice($invoice->sub_total, $invoice->order_currency_code),
            'base_sub_total' => core()->formatBasePrice($invoice->base_sub_total),
            'grand_total' => core()->formatPrice($invoice->grand_total, $invoice->order_currency_code),
            'base_grand_total' => core()->formatBasePrice($invoice->base_grand_total),
            'shipping_amount' => core()->formatPrice($invoice->shipping_amount, $invoice->order_currency_code),
            'base_shipping_amount' => core()->formatBasePrice($invoice->base_shipping_amount),
            'tax_amount' => core()->formatPrice($invoice->tax_amount, $invoice->order_currency_code),
            'base_tax_amount' => core()->formatBasePrice($invoice->base_tax_amount),
            'discount_amount' => core()->formatPrice($invoice->discount_amount, $invoice->order_currency_code),
            'base_discount_amount' => core()->formatBasePrice($invoice->base_discount_amount),
        ];
    }

    /**
     * Get formatted price for Invoice Item data.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return mixed
     */
    public function getInvoiceItemPriceData($rootValue, array $args, GraphQLContext $context)
    {
        $invoiceItem = $this->invoiceItemRepository->find($rootValue->id);
        $invoice = $invoiceItem->invoice;

        return  [
            'price' => core()->formatPrice($invoiceItem->price, $invoice->order_currency_code),
            'base_price' => core()->formatBasePrice($invoiceItem->base_price),
            'total' => core()->formatPrice($invoiceItem->total, $invoice->order_currency_code),
            'base_total' => core()->formatBasePrice($invoiceItem->base_total),
            'tax_amount' => core()->formatPrice($invoiceItem->tax_amount, $invoice->order_currency_code),
            'base_tax_amount' => core()->formatBasePrice($invoiceItem->base_tax_amount),
            'grand_total' => core()->formatPrice($invoiceItem->total + $invoiceItem->tax_amount, $invoice->order_currency_code),
            'base_grand_total' => core()->formatBasePrice($invoiceItem->base_total + $invoiceItem->base_tax_amount),
        ];
    }

    /**
     * Get formatted price for Shipment Item data.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return mixed
     */
    public function getShipmentItemPriceData($rootValue, array $args, GraphQLContext $context)
    {
        $shipmentItem = $this->shipmentItemRepository->find($rootValue->id);
        $order = $shipmentItem->shipment->order;

        return  [
            'price' => core()->formatPrice($shipmentItem->price, $order->order_currency_code),
            'base_price' => core()->formatBasePrice($shipmentItem->base_price),
            'total' => core()->formatPrice($shipmentItem->total, $order->order_currency_code),
            'base_total' => core()->formatBasePrice($shipmentItem->base_total),
        ];
    }

    /**
     * Get formatted price for Refund data.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return mixed
     */
    public function getRefundPriceData($rootValue, array $args, GraphQLContext $context)
    {
        $refund = $this->refundRepository->find($rootValue->id);
        $order = $refund->order;

        return  [
            'sub_total' => core()->formatPrice($refund->sub_total, $order->order_currency_code),
            'base_sub_total' => core()->formatBasePrice($refund->base_sub_total),
            'grand_total' => core()->formatPrice($refund->grand_total, $order->order_currency_code),
            'base_grand_total' => core()->formatBasePrice($refund->base_grand_total),
            'adjustment_refund' => core()->formatPrice($refund->adjustment_refund, $order->order_currency_code),
            'base_adjustment_refund' => core()->formatBasePrice($refund->base_adjustment_refund),
            'adjustment_fee' => core()->formatPrice($refund->adjustment_fee, $order->order_currency_code),
            'base_adjustment_fee' => core()->formatBasePrice($refund->base_adjustment_fee),
            'shipping_amount' => core()->formatPrice($refund->shipping_amount, $order->order_currency_code),
            'base_shipping_amount' => core()->formatBasePrice($refund->base_shipping_amount),
            'tax_amount' => core()->formatPrice($refund->tax_amount, $order->order_currency_code),
            'base_tax_amount' => core()->formatBasePrice($refund->base_tax_amount),
            'discount_amount' => core()->formatPrice($refund->discount_amount, $order->order_currency_code),
            'base_discount_amount' => core()->formatBasePrice($refund->base_discount_amount),
        ];
    }

    /**
     * Get formatted price for Refund Item data.
     *
     * @param  mixed  $rootValue
     * @param  array  $args
     * @param  GraphQLContext  $context
     * @return mixed
     */
    public function getRefundItemPriceData($rootValue, array $args, GraphQLContext $context)
    {
        $refundItem = $this->refundItemRepository->find($rootValue->id);
        $order = $refundItem->refund->order;

        return  [
            'price' => core()->formatPrice($refundItem->price, $order->order_currency_code),
            'base_price' => core()->formatBasePrice($refundItem->base_price),
            'total' => core()->formatPrice($refundItem->total, $order->order_currency_code),
            'base_total' => core()->formatBasePrice($refundItem->base_total),
            'tax_amount' => core()->formatPrice($refundItem->tax_amount, $order->order_currency_code),
            'base_tax_amount' => core()->formatBasePrice($refundItem->base_tax_amount),
            'discount_amount' => core()->formatPrice($refundItem->discount_amount, $order->order_currency_code),
            'base_discount_amount' => core()->formatBasePrice($refundItem->base_discount_amount),
        ];
    }
}
