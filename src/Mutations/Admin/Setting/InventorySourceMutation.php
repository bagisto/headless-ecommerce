<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Setting;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Http\Controllers\Controller;
use Webkul\Core\Rules\Code;
use Webkul\GraphQLAPI\Validators\Admin\CustomException;
use Webkul\Inventory\Repositories\InventorySourceRepository;

class InventorySourceMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected InventorySourceRepository $inventorySourceRepository)
    {
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

        $data = $args['input'];

        $validator = Validator::make($data, [
            'code'           => ['required', 'unique:inventory_sources,code', new Code],
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
            throw new CustomException($validator->messages());
        }

        try {
            $data['status'] = $data['status'] ?? 0;

            Event::dispatch('inventory.inventory_source.create.before');

            $inventorySource = $this->inventorySourceRepository->create($data);

            Event::dispatch('inventory.inventory_source.create.after', $inventorySource);

            $inventorySource->success = trans('bagisto_graphql::app.admin.settings.inventory-sources.create-success');

            return $inventorySource;
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update($rootValue, array $args, GraphQLContext $context)
    {
        if (
            empty($args['id'])
            || empty($args['input'])
        ) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $data = $args['input'];

        $id = $args['id'];

        $validator = Validator::make($data, [
            'code'           => ['required', 'unique:inventory_sources,code,'.$id, new Code],
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
            throw new CustomException($validator->messages());
        }

        $inventorySource = $this->inventorySourceRepository->find($id);

        if (! $inventorySource) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.inventory-sources.not-found'));
        }

        try {
            $data['status'] = $data['status'] ?? 0;

            Event::dispatch('inventory.inventory_source.update.before', $id);

            $inventorySource = $this->inventorySourceRepository->update($data, $id);

            Event::dispatch('inventory.inventory_source.update.after', $inventorySource);

            $inventorySource->success = trans('bagisto_graphql::app.admin.settings.inventory-sources.update-success');

            return $inventorySource;
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
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
        if (empty($args['id'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $id = $args['id'];

        $inventorySource = $this->inventorySourceRepository->find($id);

        if (! $inventorySource) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.inventory-sources.not-found'));
        }

        if ($this->inventorySourceRepository->count() == 1) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.inventory-sources.last-delete-error'));
        }

        try {
            Event::dispatch('inventory.inventory_source.delete.before', $id);

            $this->inventorySourceRepository->delete($id);

            Event::dispatch('inventory.inventory_source.delete.after', $id);

            return ['success' => trans('bagisto_graphql::app.admin.settings.inventory-sources.delete-success')];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
