<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Core\Rules\Code;
use Webkul\Core\Rules\PhoneNumber;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Inventory\Repositories\InventorySourceRepository;

class InventorySourceMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected InventorySourceRepository $inventorySourceRepository) {}

    /**
     * Store a newly created resource in storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'code'           => ['required', 'unique:inventory_sources,code', new Code],
            'name'           => 'required',
            'contact_name'   => 'required',
            'contact_email'  => 'required|email',
            'contact_number' => ['required', new PhoneNumber],
            'street'         => 'required',
            'country'        => 'required|exists:countries,code',
            'state'          => 'required',
            'city'           => 'required',
            'postcode'       => 'required',
            'latitude'       => 'nullable|numeric|between:-90,90',
            'longitude'      => 'nullable|numeric|between:-180,180',
        ]);

        try {
            $args['status'] = $args['status'] ?? 0;

            Event::dispatch('inventory.inventory_source.create.before');

            $inventorySource = $this->inventorySourceRepository->create($args);

            Event::dispatch('inventory.inventory_source.create.after', $inventorySource);

            return [
                'success'          => true,
                'message'          => trans('bagisto_graphql::app.admin.settings.inventory-sources.create-success'),
                'inventory_source' => $inventorySource,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function update(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'code'           => ['required', 'unique:inventory_sources,code,'.$args['id'], new Code],
            'name'           => 'required',
            'contact_name'   => 'required',
            'contact_email'  => 'required|email',
            'contact_number' => ['required', new PhoneNumber],
            'street'         => 'required',
            'country'        => 'required|exists:countries,code',
            'state'          => 'required',
            'city'           => 'required',
            'postcode'       => 'required',
            'latitude'       => 'nullable|numeric|between:-90,90',
            'longitude'      => 'nullable|numeric|between:-180,180',
        ]);

        $inventorySource = $this->inventorySourceRepository->find($args['id']);

        if (! $inventorySource) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.inventory-sources.not-found'));
        }

        try {
            $args['status'] = $args['status'] ?? 0;

            Event::dispatch('inventory.inventory_source.update.before', $inventorySource->id);

            $inventorySource = $this->inventorySourceRepository->update($args, $inventorySource->id);

            Event::dispatch('inventory.inventory_source.update.after', $inventorySource);

            return [
                'success'          => true,
                'message'          => trans('bagisto_graphql::app.admin.settings.inventory-sources.update-success'),
                'inventory_source' => $inventorySource,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function delete(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $inventorySource = $this->inventorySourceRepository->find($args['id']);

        if (! $inventorySource) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.inventory-sources.not-found'));
        }

        if ($this->inventorySourceRepository->count() == 1) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.inventory-sources.last-delete-error'));
        }

        try {
            Event::dispatch('inventory.inventory_source.delete.before', $args['id']);

            $inventorySource->delete();

            Event::dispatch('inventory.inventory_source.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.settings.inventory-sources.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
