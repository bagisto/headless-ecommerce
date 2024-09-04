<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Catalog\AttributeFamilies;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Attribute\Repositories\AttributeFamilyRepository;
use Webkul\Attribute\Repositories\AttributeGroupRepository;
use Webkul\Core\Rules\Code;
use Webkul\GraphQLAPI\Validators\CustomException;

class AttributeFamilyMutation extends Controller
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
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'code'                      => ['required', 'unique:attribute_families,code', new Code],
            'name'                      => 'required',
            'attribute_groups.*.code'   => 'required',
            'attribute_groups.*.name'   => 'required',
            'attribute_groups.*.column' => 'required|in:1,2',
        ]);

        try {
            Event::dispatch('catalog.attribute_family.create.before');

            $attributeFamily = $this->attributeFamilyRepository->create($args);

            Event::dispatch('catalog.attribute_family.create.before', $attributeFamily);

            return [
                'success'          => true,
                'message'          => trans('bagisto_graphql::app.admin.catalog.attribute-families.create-success'),
                'attribute_family' => $attributeFamily,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return array
     */
    public function update(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'code'                      => ['required', 'unique:attribute_families,code,'.$args['id'], new Code],
            'name'                      => 'required',
            'attribute_groups.*.code'   => 'required',
            'attribute_groups.*.name'   => 'required',
            'attribute_groups.*.column' => 'required|in:1,2',
        ]);

        $attributeFamily = $this->attributeFamilyRepository->find($args['id']);

        if (! $attributeFamily) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.attribute-families.not-found'));
        }

        $attributeGroups = [];

        foreach ($args['attribute_groups'] as $key => $attributeGroup) {
            if (isset($attributeGroup['id'])) {
                $id = $attributeGroup['id'];

                unset($attributeGroup['id']);

                $attributeGroups[$id] = $attributeGroup;
            } else {
                $attributeGroups['group_'.$key] = $attributeGroup;
            }
        }

        $args['attribute_groups'] = $attributeGroups;

        try {
            Event::dispatch('catalog.attribute_family.update.before', $attributeFamily->id);

            $attributeFamily = $this->attributeFamilyRepository->update($args, $attributeFamily->id);

            Event::dispatch('catalog.attribute_family.update.after', $attributeFamily);

            return [
                'success'          => true,
                'message'          => trans('bagisto_graphql::app.admin.catalog.attribute-families.update-success'),
                'attribute_family' => $attributeFamily,
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
        if ($this->attributeFamilyRepository->count() == 1) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.attribute-families.last-delete-error'));
        }

        $attributeFamily = $this->attributeFamilyRepository->find($args['id']);

        if (! $attributeFamily) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.attribute-families.not-found'));
        }

        if ($attributeFamily->products()->count()) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.attribute-families.attribute-product-error'));
        }

        try {
            Event::dispatch('catalog.attribute_family.delete.before', $args['id']);

            $attributeFamily->delete();

            Event::dispatch('catalog.attributeFamily.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.catalog.attribute-families.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
