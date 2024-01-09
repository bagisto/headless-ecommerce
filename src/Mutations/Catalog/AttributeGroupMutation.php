<?php

namespace Webkul\GraphQLAPI\Mutations\Catalog;

use Exception;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use App\Http\Controllers\Controller;
use Webkul\Attribute\Repositories\AttributeFamilyRepository;
use Webkul\Attribute\Repositories\AttributeGroupRepository;

class AttributeGroupMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Attribute\Repositories\AttributeFamilyRepository  $attributeFamilyRepository
     * @param  \Webkul\Attribute\Repositories\AttributeGroupRepository  $attributeGroupRepository
     * @return void
     */
    public function __construct(
        protected AttributeFamilyRepository $attributeFamilyRepository,
        protected AttributeGroupRepository $attributeGroupRepository,
    )
    {
        $this->middleware('auth:admin-api');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'name'                => 'string|required',
            'position'            => 'numeric|required',
            'attribute_family_id' => 'numeric|required',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $attributeFamily = $this->attributeFamilyRepository->findOrFail($data['attribute_family_id']);

            unset($data['attribute_family_id']);

            Event::dispatch('catalog.attributeGroup.create.before');

            $attributeGroup = $attributeFamily->attribute_groups()->create($data);

            Event::dispatch('catalog.attributeGroup.create.before', $attributeGroup);

            return $attributeGroup;
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
        if (
            empty($args['id'])
            || ! empty($args['input'])
        ) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];

        $id = $args['id'];

        $validator = Validator::make($data, [
            'name'                => 'string|required',
            'position'            => 'numeric|required',
            'attribute_family_id' => 'numeric|required',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $attributeFamily = $this->attributeFamilyRepository->findOrFail($data['attribute_family_id']);

            unset($data['attribute_family_id']);

            Event::dispatch('catalog.attributeGroup.update.before', $id);

            $previousAttributeGroupIds = $attributeFamily->attribute_groups()->pluck('id');

            if (is_numeric($index = $previousAttributeGroupIds->search($id)) ) {
                $attributeGroup = $this->attributeGroupRepository->find($id);

                $attributeGroup->update($data);

                Event::dispatch('catalog.attributeGroup.update.before', $attributeGroup);

                return $attributeGroup;
            }
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
        if (empty($args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $id = $args['id'];

        $attributeGroup = $this->attributeGroupRepository->findOrFail($id);

        if (! empty($attributeGroup->is_user_defined)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-customer-group'));
        }

        try {
            Event::dispatch('catalog.attributeGroup.delete.before', $id);

            $this->attributeGroupRepository->delete($id);

            Event::dispatch('catalog.attributeGroup.delete.after', $id);

            return ['success' => trans('admin::app.response.delete-success', ['name' => 'Attribute Group'])];
        } catch(\Exception $e) {
            throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Attribute Group']));
        }
    }
}
