<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Sales\Shipments;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Sales\Repositories\OrderItemRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\ShipmentRepository;

class ShipmentMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected ShipmentRepository $shipmentRepository,
        protected OrderRepository $orderRepository,
        protected OrderItemRepository $orderItemRepository
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

        if (! $order->canShip()) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.shipments.shipment-error'));
        }

        try {
            if (! isset($args['shipment_data'])) {
                throw new CustomException(trans('bagisto_graphql::app.admin.sales.shipments.creation-error'));
            }

            $shipmentData = [];

            foreach ($args['shipment_data'] as $arg) {
                $shipmentData[$arg['order_item_id']] = [
                    $args['inventory_source_id'] => $arg['quantity'],
                ];
            }

            $shipment['shipment']['carrier_title'] = $args['carrier_title'];
            $shipment['shipment']['track_number'] = $args['track_number'];
            $shipment['shipment']['source'] = $args['inventory_source_id'];
            $shipment['shipment']['items'] = $shipmentData;

            bagisto_graphql()->validate($shipment, [
                'shipment.source'    => 'required',
                'shipment.items.*.*' => 'required|numeric|min:0',
            ]);

            if (! $this->isInventoryValidate($shipment)) {
                throw new CustomException(trans('bagisto_graphql::app.admin.sales.shipments.quantity-invalid'));
            }

            $shipment = $this->shipmentRepository->create(array_merge($shipment, [
                'order_id' => $args['order_id'],
            ]));

            return [
                'success'  => true,
                'message'  => trans('bagisto_graphql::app.admin.sales.shipments.create-success'),
                'shipment' => $shipment,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Checks if requested quantity available or not
     *
     * @param  array  $data
     * @return bool
     */
    public function isInventoryValidate(&$data)
    {
        if (! isset($data['shipment']['items'])) {
            return;
        }

        $valid = false;

        $inventorySourceId = $data['shipment']['source'];

        foreach ($data['shipment']['items'] as $itemId => $inventorySource) {
            if (! $qty = $inventorySource[$inventorySourceId]) {
                unset($data['shipment']['items'][$itemId]);

                continue;
            }

            $orderItem = $this->orderItemRepository->find($itemId);

            if ($orderItem->qty_to_ship < $qty) {
                return false;
            }

            if ($orderItem->getTypeInstance()->isComposite()) {
                foreach ($orderItem->children as $child) {
                    if (! $child->qty_ordered) {
                        continue;
                    }

                    $finalQty = ($child->qty_ordered / $orderItem->qty_ordered) * $qty;

                    $availableQty = $child->product->inventories()
                        ->where('inventory_source_id', $inventorySourceId)
                        ->sum('qty');

                    if (
                        $child->qty_to_ship < $finalQty
                        || $availableQty < $finalQty
                    ) {
                        return false;
                    }
                }
            } else {
                $availableQty = $orderItem->product->inventories()
                    ->where('inventory_source_id', $inventorySourceId)
                    ->sum('qty');

                if (
                    $orderItem->qty_to_ship < $qty
                    || $availableQty < $qty
                ) {
                    return false;
                }
            }

            $valid = true;
        }

        return $valid;
    }
}
