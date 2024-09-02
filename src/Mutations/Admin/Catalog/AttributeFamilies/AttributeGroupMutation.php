<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Catalog\AttributeFamilies;

use App\Http\Controllers\Controller;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Attribute\Repositories\AttributeFamilyRepository;
use Webkul\Attribute\Repositories\AttributeGroupRepository;
use Webkul\Core\Rules\Code;
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
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'code'                => ['required', 'unique:attribute_groups,code', new Code],
            'name'                => ['required', 'unique:attribute_groups,name'],
            'column'              => 'required',
            'position'            => 'required',
            'attribute_family_id' => 'required',
        ]);

        $attributeFamily = $this->attributeFamilyRepository->find($args['attribute_family_id']);

        if (! $attributeFamily) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.attribute-families.not-found'));
        }

        try {
            $attributeGroup = $attributeFamily->attribute_groups()->create(array_merge($args, [
                'is_user_defined' => 1,
            ]));

            return [
                'success'         => true,
                'message'         => trans('bagisto_graphql::app.admin.catalog.attribute-groups.create-success'),
                'attribute_group' => $attributeGroup,
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
            'code'                => ['required', 'unique:attribute_groups,code,'.$args['id'], new Code],
            'name'                => ['required', 'unique:attribute_groups,name,'.$args['id']],
            'column'              => 'required',
            'position'            => 'required',
            'attribute_family_id' => 'required',
        ]);

        $attributeFamily = $this->attributeFamilyRepository->find($args['attribute_family_id']);

        if (! $attributeFamily) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.attribute-families.not-found'));
        }

        unset($args['attribute_family_id']);

        $attributeGroup = $this->attributeGroupRepository->find($args['id']);

        if (! $attributeGroup) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.attribute-groups.not-found'));
        }

        try {
            $previousAttributeGroupIds = $attributeFamily->attribute_groups()->pluck('id');

            if (is_numeric($previousAttributeGroupIds->search($args['id']))) {
                $attributeGroup = $this->attributeGroupRepository->update($args, $attributeGroup->id);
            }

            return [
                'success'         => true,
                'message'         => trans('bagisto_graphql::app.admin.catalog.attribute-groups.update-success'),
                'attribute_group' => $attributeGroup,
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
        $attributeGroup = $this->attributeGroupRepository->find($args['id']);

        if (! $attributeGroup) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.attribute-groups.not-found'));
        }

        if ($attributeGroup->is_user_defined === 0) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.attribute-groups.user-define-error'));
        }

        try {
            $attributeGroup->delete();

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.catalog.attribute-groups.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
