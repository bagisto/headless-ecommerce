<?php

namespace Webkul\GraphQLAPI\Mutations\Catalog;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Webkul\Attribute\Http\Controllers\Controller;
use Webkul\Attribute\Repositories\AttributeGroupRepository;
use Webkul\Attribute\Repositories\AttributeFamilyRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class AttributeFamilyMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Attribute\Repositories\AttributeGroupRepository  $attributeGroupRepository
     * @param  \Webkul\Attribute\Repositories\AttributeFamilyRepository  $attributeFamilyRepository
     * @return void
     */
    public function __construct(
        protected AttributeGroupRepository $attributeGroupRepository,
        protected AttributeFamilyRepository $attributeFamilyRepository
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
        if (! isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];

        if(! isset($data['attribute_groups'])) {
            $data['attribute_groups'] = [];
        }

        $validator = Validator::make($data, [
            'code' => ['required', 'unique:attribute_families,code', new \Webkul\Core\Contracts\Validations\Code],
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['id']) || !isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];
        $id = $args['id'];

        $validator = Validator::make($data, [
            'code' => ['required', 'unique:attribute_families,code,' . $id, new \Webkul\Core\Contracts\Validations\Code],
            'name' => 'required',
        ]);
        
        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        $attributeFamily = $this->attributeFamilyRepository->findOrFail($id);

        $attribute_groups = [];
        if ( isset($data['attribute_groups']) && $data['attribute_groups']) {
            $previousAttributeGroupIds = $attributeGroupArray = $attributeFamily->attribute_groups()->pluck('id');

            foreach ($attributeGroupArray->toArray() as $key => $attributeGroupId) {
                if (is_numeric($index = $previousAttributeGroupIds->search($attributeGroupId))) {
                    $previousAttributeGroupIds->forget($index);
                }

                $this->attributeGroupRepository->delete($attributeGroupId);
            }
            
            foreach ($data['attribute_groups'] as $key => $attributeGroup) {
                $index = 'group_' . ($key + 1);
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
        if (! isset($args['id']) || (isset($args['id']) && !$args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $id = $args['id'];

        $attributeFamily = $this->attributeFamilyRepository->findOrFail($id);

        if ($this->attributeFamilyRepository->count() == 1) {
            throw new Exception(trans('admin::app.response.last-delete-error', ['name' => 'Family']));

        } elseif ($attributeFamily->products()->count()) {
            throw new Exception(trans('admin::app.response.attribute-product-error', ['name' => 'Attribute family']));
        } else {

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
}
