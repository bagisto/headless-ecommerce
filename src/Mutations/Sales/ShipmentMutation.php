<?php

namespace Webkul\GraphQLAPI\Mutations\Sales;

use Exception;
use Illuminate\Support\Facades\Validator;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\OrderItemRepository;
use Webkul\Sales\Repositories\ShipmentRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ShipmentMutation extends Controller
{
    /**
     * Initialize _config, a default request parameter with route
     *
     * @param array
     */
    protected $_config;

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
        $this->guard = 'admin-api';

        auth()->setDefaultDriver($this->guard);

        $this->_config = request('_config');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (!isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $params = $args['input'];
        $orderId = $params['order_id'];

        $order = $this->orderRepository->findOrFail($orderId);

        if (! $order->canShip()) {
            throw new Exception(trans('admin::app.sales.shipments.order-error'));
        }

        try {

            $shipmentData = [];

            if (isset($params['shipment_data'])) {
                foreach ($params['shipment_data'] as $data) {

                    $shipmentData[$data['order_item_id']] = [
                        $params['inventory_source_id'] => $data['quantity']
                    ];
                }

                $shipment['shipment']['items'] =  $shipmentData;

                $shipment['shipment']['carrier_title'] = $params['carrier_title'];
                $shipment['shipment']['track_number']  = $params['track_number'];
                $shipment['shipment']['source']        = $params['inventory_source_id'];

                $validator = Validator::make($shipment, [
                    'shipment.source'        => 'required',
                    'shipment.items.*.*'     => 'required|numeric|min:0',
                ]);

                if ($validator->fails()) {
                    throw new Exception($validator->messages());
                }

                if (!$this->isInventoryValidate($shipment)) {
                    throw new Exception(trans('admin::app.sales.shipments.quantity-invalid'));
                }

                $shipmentData = $this->shipmentRepository->create(array_merge($shipment, ['order_id' => $orderId]));

                return $shipmentData;
            } else {
                throw new Exception(trans('admin::app.sales.invoices.product-error'));
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
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
        if (!isset($data['shipment']['items'])) {
            return;
        }

        $valid = false;

        $inventorySourceId = $data['shipment']['source'];

        foreach ($data['shipment']['items'] as $itemId => $inventorySource) {
            if ($qty = $inventorySource[$inventorySourceId]) {
                $orderItem = $this->orderItemRepository->find($itemId);

                if ($orderItem->qty_to_ship < $qty) {
                    return false;
                }

                if ($orderItem->getTypeInstance()->isComposite()) {
                    foreach ($orderItem->children as $child) {
                        if (!$child->qty_ordered) {
                            continue;
                        }

                        $finalQty = ($child->qty_ordered / $orderItem->qty_ordered) * $qty;

                        $availableQty = $child->product->inventories()
                            ->where('inventory_source_id', $inventorySourceId)
                            ->sum('qty');

                        if ($child->qty_to_ship < $finalQty || $availableQty < $finalQty) {
                            return false;
                        }
                    }
                } else {
                    $availableQty = $orderItem->product->inventories()
                        ->where('inventory_source_id', $inventorySourceId)
                        ->sum('qty');

                    if ($orderItem->qty_to_ship < $qty || $availableQty < $qty) {
                        return false;
                    }
                }

                $valid = true;
            } else {
                unset($data['shipment']['items'][$itemId]);
            }
        }

        return $valid;
    }
}
