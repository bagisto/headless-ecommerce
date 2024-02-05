<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Sales\Shipments;

use Exception;
use Illuminate\Support\Facades\Validator;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\ShipmentRepository;
use Webkul\Sales\Repositories\OrderItemRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Validators\Admin\CustomException;

class ShipmentMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Sales\Repositories\ShipmentRepository   $shipmentRepository
     * @param  \Webkul\Sales\Repositories\OrderRepository  $orderRepository
     * @param  \Webkul\Sales\Repositories\OrderitemRepository  $orderItemRepository
     * @return void
     */
    public function __construct(
        protected ShipmentRepository $shipmentRepository,
        protected OrderRepository $orderRepository,
        protected OrderItemRepository $orderItemRepository
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

        if (! $order->canShip()) {
            throw new CustomException(trans('bagisto_graphql::app.admin.sales.shipments.shipment-error'));
        }

        try {
            if (! isset($params['shipment_data'])) {
                throw new CustomException(trans('bagisto_graphql::app.admin.sales.shipments.creation-error'));
            }

            $shipmentData = [];

            foreach ($params['shipment_data'] as $data) {
                $shipmentData[$data['order_item_id']] = [
                    $params['inventory_source_id'] => $data['quantity']
                ];
            }

            $shipment['shipment']['carrier_title'] = $params['carrier_title'];
            $shipment['shipment']['track_number'] = $params['track_number'];
            $shipment['shipment']['source'] = $params['inventory_source_id'];
            $shipment['shipment']['items'] =  $shipmentData;

            $validator = Validator::make($shipment, [
                'shipment.source'    => 'required',
                'shipment.items.*.*' => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                throw new CustomException($validator->messages());
            }

            if (! $this->isInventoryValidate($shipment)) {
                throw new CustomException(trans('bagisto_graphql::app.admin.sales.shipments.quantity-invalid'));
            }

            $shipmentData = $this->shipmentRepository->create(array_merge($shipment, ['order_id' => $orderId]));

            return $shipmentData;
        } catch (Exception $e) {
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
