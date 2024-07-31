<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Catalog\AttributeFamilies;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Attribute\Repositories\AttributeFamilyRepository;
use Webkul\Attribute\Repositories\AttributeGroupRepository;
use Webkul\GraphQLAPI\Validators\CustomException;

class AttributeGroupMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected AttributeFamilyRepository $attributeFamilyRepository,
        protected AttributeGroupRepository $attributeGroupRepository
    ) {}

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
            'name'                => 'string|required',
            'position'            => 'numeric|required',
            'attribute_family_id' => 'numeric|required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        try {
            $attributeFamily = $this->attributeFamilyRepository->findOrFail($data['attribute_family_id']);

            unset($data['attribute_family_id']);

            Event::dispatch('catalog.attributeGroup.create.before');

            $attributeGroup = $attributeFamily->attribute_groups()->create($data);

            Event::dispatch('catalog.attributeGroup.create.before', $attributeGroup);

            return $attributeGroup;
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
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
            || empty($args['input'])
        ) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $data = $args['input'];

        $id = $args['id'];

        $validator = Validator::make($data, [
            'name'                => 'string|required',
            'position'            => 'numeric|required',
            'attribute_family_id' => 'numeric|required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        try {
            $attributeFamily = $this->attributeFamilyRepository->findOrFail($data['attribute_family_id']);

            unset($data['attribute_family_id']);

            Event::dispatch('catalog.attributeGroup.update.before', $id);

            $previousAttributeGroupIds = $attributeFamily->attribute_groups()->pluck('id');

            if (is_numeric($previousAttributeGroupIds->search($id))) {
                $attributeGroup = $this->attributeGroupRepository->find($id);

                $attributeGroup->update($data);

                Event::dispatch('catalog.attributeGroup.update.before', $attributeGroup);

                return $attributeGroup;
            }
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

        $attributeGroup = $this->attributeGroupRepository->findOrFail($id);

        if (empty($attributeGroup->is_user_defined)) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.attribute-groups.error-customer-group'));
        }

        try {
            Event::dispatch('catalog.attributeGroup.delete.before', $id);

            $this->attributeGroupRepository->delete($id);

            Event::dispatch('catalog.attributeGroup.delete.after', $id);

            return ['success' => trans('bagisto_graphql::app.admin.catalog.attribute-groups.delete-success')];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
