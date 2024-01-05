<?php

namespace Webkul\GraphQLAPI\Mutations\Catalog;

use Exception;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use App\Http\Controllers\Controller;
use Webkul\Attribute\Repositories\AttributeFamilyRepository;
use Webkul\Attribute\Repositories\AttributeGroupRepository;
use Webkul\Core\Rules\Code;

class AttributeFamilyMutation extends Controller
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
        if (empty($args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];

        if (! isset($data['attribute_groups'])) {
            $data['attribute_groups'] = [];
        }

        $validator = Validator::make($data, [
            'code' => ['required', 'unique:attribute_families,code', new Code],
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            Event::dispatch('catalog.attributeFamily.create.before');

            $attributeFamily = $this->attributeFamilyRepository->create($data);

            Event::dispatch('catalog.attributeFamily.create.before', $attributeFamily);

            return $attributeFamily;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
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
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];

        $id = $args['id'];

        $validator = Validator::make($data, [
            'code' => ['required', 'unique:attribute_families,code,' . $id, new Code],
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        $attributeFamily = $this->attributeFamilyRepository->findOrFail($id);

        $attribute_groups = [];

        if (! empty($data['attribute_groups'])) {
            $previousAttributeGroupIds = $attributeGroupArray = $attributeFamily->attribute_groups()->pluck('id');

            foreach ($attributeGroupArray->toArray() as $key => $attributeGroupId) {
                if (is_numeric($index = $previousAttributeGroupIds->search($attributeGroupId))) {
                    $previousAttributeGroupIds->forget($index);
                }

                $this->attributeGroupRepository->delete($attributeGroupId);
            }

            foreach ($data['attribute_groups'] as $key => $attributeGroup) {
                $index = $key + 1;

                $attribute_groups[$index] = $attributeGroup;
            }

            $data['attribute_groups'] = $attribute_groups;
        }
        try {
            Event::dispatch('catalog.attributeFamily.update.before', $id);

            $attributeFamily = $this->attributeFamilyRepository->update($data, $id);

            Event::dispatch('catalog.attributeFamily.update.before', $attributeFamily);

            return $attributeFamily;
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

        if ($this->attributeFamilyRepository->count() == 1) {
            throw new Exception(trans('admin::app.response.last-delete-error', ['name' => 'Family']));
        }

        $attributeFamily = $this->attributeFamilyRepository->findOrFail($id);

        if ($attributeFamily->products()->count()) {
            throw new Exception(trans('admin::app.response.attribute-product-error', ['name' => 'Attribute family']));
        }

        try {
            Event::dispatch('catalog.attributeFamily.delete.before', $id);

            $this->attributeFamilyRepository->delete($id);

            Event::dispatch('catalog.attributeFamily.delete.after', $id);

            return ['success' => trans('admin::app.response.delete-success', ['name' => 'Family'])];
        } catch(\Exception $e) {
            throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Family']));
        }
    }
}
