<?php

namespace Webkul\GraphQLAPI\Mutations\Setting;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Webkul\Inventory\Http\Controllers\Controller;
use Webkul\Inventory\Repositories\InventorySourceRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class InventorySourceMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Inventory\Repositories\InventorySourceRepository  $inventorySourceRepository
     * @return void
     */
    public function __construct(
        protected InventorySourceRepository $inventorySourceRepository
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

        $data = $args['input'];

        $validator = Validator::make($data, [
            'code'           => ['required', 'unique:inventory_sources,code', new \Webkul\Core\Contracts\Validations\Code],
            'name'           => 'required',
            'contact_name'   => 'required',
            'contact_email'  => 'required|email',
            'contact_number' => 'required',
            'street'         => 'required',
            'country'        => 'required',
            'state'          => 'required',
            'city'           => 'required',
            'postcode'       => 'required',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $data['status'] = !isset($data['status']) ? 0 : 1;

            Event::dispatch('inventory.inventory_source.create.before');

            $inventorySource = $this->inventorySourceRepository->create($data);

            Event::dispatch('inventory.inventory_source.create.after', $inventorySource);

            return $inventorySource;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($rootValue, array $args, GraphQLContext $context)
    {
        if (!isset($args['id']) || !isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];
        $id = $args['id'];

        $validator = Validator::make($data, [
            'code'           => ['required', 'unique:inventory_sources,code,' . $id, new \Webkul\Core\Contracts\Validations\Code],
            'name'           => 'required',
            'contact_name'   => 'required',
            'contact_email'  => 'required|email',
            'contact_number' => 'required',
            'street'         => 'required',
            'country'        => 'required',
            'state'          => 'required',
            'city'           => 'required',
            'postcode'       => 'required',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $data['status'] = !isset($data['status']) ? 0 : 1;

            Event::dispatch('inventory.inventory_source.update.before', $id);

            $inventorySource = $this->inventorySourceRepository->update($data, $id);

            Event::dispatch('inventory.inventory_source.update.after', $inventorySource);

            return $inventorySource;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        if (!isset($args['id']) || (isset($args['id']) && !$args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $id = $args['id'];

        $inventorySource = $this->inventorySourceRepository->findOrFail($id);

        if ($this->inventorySourceRepository->count() == 1) {
            throw new Exception(trans('admin::app.settings.inventory_sources.last-delete-error'));
        } else {
            try {
                Event::dispatch('inventory.inventory_source.delete.before', $id);

                $this->inventorySourceRepository->delete($id);

                Event::dispatch('inventory.inventory_source.delete.after', $id);

                return ['success' => trans('admin::app.settings.inventory_sources.delete-success')];
            } catch (\Exception $e) {
                throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Inventory source']));
            }
        }
    }
}
