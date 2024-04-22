<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Catalog\Attributes;

use Webkul\Core\Rules\Code;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Attribute\Repositories\AttributeOptionRepository;
use Webkul\GraphQLAPI\Validators\Admin\CustomException;

class AttributeMutation extends Controller
{
    /**
     * localeFields array
     *
     * @var Array
     */
    protected $localeFields = [
        'name',
    ];

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Attribute\Repositories\AttributeRepository  $attributeRepository
     * @param  \Webkul\Attribute\Repositories\AttributeOptionRepository  $attributeOptionRepository
     * @return void
     */
    public function __construct(
        protected AttributeRepository $attributeRepository,
        protected AttributeOptionRepository $attributeOptionRepository
    ) {
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
            'code'       => ['required', 'unique:attributes,code', new Code],
            'admin_name' => 'required',
            'type'       => 'required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        try {
            if (
                isset($data['translations'])
                && is_array($data['translations'])
            ) {
                $localeFields = bagisto_graphql()->manageLocaleFields($data['translations'], $this->localeFields);

                $data = array_merge($data, $localeFields);

                unset($data['translations']);
            }

            $swatch_type = $data['swatch_type'] ?? '';

            $swatch_value = [];

            if (! empty($data['options'])) {
                $options = $this->manageAttribnuteOptions($data);

                $data['options'] = $options['options'] ?? [];

                $swatch_value = $options['swatch_value'] ?? [];
            }

            $data['is_user_defined'] = 1;

            Event::dispatch('catalog.attribute.create.before');

            $attribute = $this->attributeRepository->create($data);

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

            return $attribute;
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
            'code'       => ['required', 'unique:attributes,code,'.$id, new Code],
            'admin_name' => 'required',
            'type'       => 'required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        try {
            if (
                isset($data['translations'])
                && is_array($data['translations'])
            ) {
                $localeFields = bagisto_graphql()->manageLocaleFields($data['translations'], $this->localeFields);

                $data = array_merge($data, $localeFields);

                unset($data['translations']);
            }

            $swatch_type = $data['swatch_type'] ?? '';

            $swatch_value = [];

            if (! empty($data['options'])) {
                $options = $this->manageAttribnuteOptions($data);

                $data['options'] = $options['options'] ?? [];

                $swatch_value = $options['swatch_value'] ?? [];
            }

            $data['is_user_defined'] = 1;

            Event::dispatch('catalog.attribute.update.before', $id);

            $attribute = $this->attributeRepository->update($data, $id);

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

            return $attribute;
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
        if (
            empty($args['id'])
        ) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $id = $args['id'];

        $attribute = $this->attributeRepository->findOrFail($id);

        if (! $attribute->is_user_defined) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.attributes.user-define-error'));
        }

        try {
            Event::dispatch('catalog.attribute.delete.before', $id);

            $this->attributeRepository->delete($id);

            Event::dispatch('catalog.attribute.delete.after', $id);

            return ['success' => trans('bagisto_graphql::app.admin.catalog.attributes.delete-success')];
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
    public function manageAttribnuteOptions($data)
    {
        $response = [];
        $options = [];

        foreach ($data['options'] as $index => $option) {
            if (
                empty($option['admin_name'])
                || !  is_array($option['translations'])
            ) {
                continue;
            }

            $key = strtolower(str_replace(" ", "_", $option['admin_name']));

            if ($attributeOption = $this->attributeOptionRepository->where('admin_name', $option['admin_name'])->first()) {
                $key = $attributeOption->id;
            }

            $options[$key] = [
                'admin_name' => $option['admin_name'],
                'sort_order' => $option['sort_order'] ?? ($index + 1),
                'isNew'      => $option["isNew"] ?? false,
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
