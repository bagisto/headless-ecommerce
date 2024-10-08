<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Catalog\Attributes;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Attribute\Repositories\AttributeOptionRepository;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Core\Rules\Code;
use Webkul\GraphQLAPI\Validators\CustomException;

class AttributeMutation extends Controller
{
    /**
     * localeFields array
     *
     * @var array
     */
    protected $localeFields = [
        'name',
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected AttributeRepository $attributeRepository,
        protected AttributeOptionRepository $attributeOptionRepository
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
            'code'       => ['required', 'unique:attributes,code', new Code],
            'admin_name' => 'required',
            'type'       => 'required',
        ]);

        try {
            if (
                isset($args['translations'])
                && is_array($args['translations'])
            ) {
                $localeFields = bagisto_graphql()->manageLocaleFields($args['translations'], $this->localeFields);

                $args = array_merge($args, $localeFields);

                unset($args['translations']);
            }

            $swatch_type = $args['swatch_type'] ?? '';

            $swatch_value = [];

            if (! empty($args['options'])) {
                $options = $this->manageAttributeOptions($args);

                $args['options'] = $options['options'] ?? [];

                $swatch_value = $options['swatch_value'] ?? [];
            }

            $args['is_user_defined'] = 1;

            Event::dispatch('catalog.attribute.create.before');

            $attribute = $this->attributeRepository->create($args);

            if (
                isset($attribute->id)
                && $swatch_type == 'image'
            ) {
                foreach ($attribute->options as $option) {
                    if (
                        isset($option->admin_name)
                        && isset($swatch_value[$option->admin_name])
                        && $swatch_value[$option->admin_name]
                    ) {
                        bagisto_graphql()->uploadImage($option, $swatch_value[$option->admin_name], 'attribute_option/', 'swatch_value');
                    }
                }
            }

            Event::dispatch('catalog.attribute.create.after', $attribute);

            return [
                'success'   => true,
                'message'   => trans('bagisto_graphql::app.admin.catalog.attributes.create-success'),
                'attribute' => $attribute,
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
        $attribute = $this->attributeRepository->find($args['id']);

        if (! $attribute) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.attributes.not-found'));
        }

        bagisto_graphql()->validate($args, [
            'code'       => ['required', 'unique:attributes,code,'.$args['id'], new Code],
            'admin_name' => 'required',
            'type'       => 'required',
        ]);

        try {
            if (
                isset($args['translations'])
                && is_array($args['translations'])
            ) {
                $localeFields = bagisto_graphql()->manageLocaleFields($args['translations'], $this->localeFields);

                $args = array_merge($args, $localeFields);

                unset($args['translations']);
            }

            $swatch_type = $args['swatch_type'] ?? '';

            $swatch_value = [];

            if (! empty($args['options'])) {
                $options = $this->manageAttributeOptions($args);

                $args['options'] = $options['options'] ?? [];

                $swatch_value = $options['swatch_value'] ?? [];
            }

            Event::dispatch('catalog.attribute.update.before', $args['id']);

            $attribute = $this->attributeRepository->update($args, $args['id']);

            if (
                isset($attribute->id)
                && $swatch_type == 'image'
            ) {
                foreach ($attribute->options as $option) {
                    if (
                        isset($option->admin_name)
                        && isset($swatch_value[$option->admin_name])
                        && $swatch_value[$option->admin_name]
                    ) {
                        bagisto_graphql()->uploadImage($option, $swatch_value[$option->admin_name], 'attribute_option/', 'swatch_value');
                    }
                }
            }

            Event::dispatch('catalog.attribute.update.after', $attribute);

            return [
                'success'   => true,
                'message'   => trans('bagisto_graphql::app.admin.catalog.attributes.update-success'),
                'attribute' => $attribute,
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
        $attribute = $this->attributeRepository->find($args['id']);

        if (! $attribute) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.attributes.not-found'));
        }

        if (! $attribute->is_user_defined) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.attributes.user-define-error'));
        }

        try {
            Event::dispatch('catalog.attribute.delete.before', $args['id']);

            $attribute->delete();

            Event::dispatch('catalog.attribute.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.catalog.attributes.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * manage the attribute's options.
     *
     * @param  array  $data
     * @return array
     */
    public function manageAttributeOptions($data)
    {
        $response = [];
        $options = [];

        foreach ($data['options'] as $index => $option) {
            if (
                empty($option['admin_name'])
                || ! is_array($option['translations'])
            ) {
                continue;
            }

            $key = strtolower(str_replace(' ', '_', $option['admin_name']));

            if ($attributeOption = $this->attributeOptionRepository->findOneByField('admin_name', $option['admin_name'])) {
                $key = $attributeOption->id;
            }

            $options[$key] = [
                'admin_name' => $option['admin_name'],
                'sort_order' => $option['sort_order'] ?? ($index + 1),
                'isNew'      => $option['isNew'] ?? false,
                'isDelete'   => $option['isDelete'] ?? false,
            ];

            if (! empty($option['swatch_value'])) {
                if ($data['swatch_type'] == 'image') {
                    $swatch_value[$option['admin_name']] = $option['swatch_value'];

                    unset($option['swatch_value']);
                } else {
                    $options[$key]['swatch_value'] = $option['swatch_value'];
                }
            }

            $localeFields = bagisto_graphql()->manageLocaleFields($option['translations'], ['label']);

            $options[$key] = array_merge($options[$key], $localeFields);
        }

        $response = [
            'options'      => $options,
            'swatch_value' => $swatch_value,
        ];

        return $response;
    }
}
