<?php

namespace Webkul\GraphQLAPI\Mutations\Catalog;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Webkul\Attribute\Http\Controllers\Controller;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Attribute\Repositories\AttributeOptionRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class AttributeMutation extends Controller
{
    /**
     * localeFields array
     *
     * @var Array
     */
    protected $localeFields = [
        'name'
    ];

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Attribute\Repositories\AttributeRepository       $attributeRepository
     * @param  \Webkul\Attribute\Repositories\AttributeOptionRepository $attributeOptionRepository
     * @return void
     */
    public function __construct(
        protected AttributeRepository $attributeRepository,
        protected AttributeOptionRepository $attributeOptionRepository
    ) {
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
        if (!isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'code'       => ['required', 'unique:attributes,code', new \Webkul\Core\Contracts\Validations\Code],
            'admin_name' => 'required',
            'type'       => 'required',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            if (isset($data['translations']) && is_array($data['translations'])) {
                $localeFields = bagisto_graphql()->manageLocaleFields($data['translations'], $this->localeFields);

                $data = array_merge($data, $localeFields);
                unset($data['translations']);
            }

            $swatch_type = isset($data['swatch_type']) ? $data['swatch_type'] : '';

            $swatch_value = [];
            if (isset($data['options']) && $data['options']) {
                $options = $this->manageAttribnuteOptions($data);

                $data['options'] = (isset($options['options']) && $options['options']) ? $options['options'] : [];
                $swatch_value = (isset($options['swatch_value']) && $options['swatch_value']) ? $options['swatch_value'] : [];
            }

            $data['is_user_defined'] = 1;

            Event::dispatch('catalog.attribute.create.before');

            $attribute = $this->attributeRepository->create($data);

            if (isset($attribute->id) && $swatch_type == 'image') {

                foreach ($attribute->options as $key => $option) {
                    if (isset($option->admin_name) && isset($swatch_value[$option->admin_name]) && $swatch_value[$option->admin_name]) {
                        bagisto_graphql()->uploadImage($option, $swatch_value[$option->admin_name], 'attribute_option/', 'swatch_value');
                    }
                }
            }

            Event::dispatch('catalog.attribute.create.after', $attribute);

            return $attribute;
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
        if (!isset($args['id']) || !isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];
        $id = $args['id'];

        $validator = Validator::make($data, [
            'code'       => ['required', 'unique:attributes,code,' . $id, new \Webkul\Core\Contracts\Validations\Code],
            'admin_name' => 'required',
            'type'       => 'required',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            if (isset($data['translations']) && is_array($data['translations'])) {
                $localeFields = bagisto_graphql()->manageLocaleFields($data['translations'], $this->localeFields);

                $data = array_merge($data, $localeFields);
                unset($data['translations']);
            }

            $swatch_type = isset($data['swatch_type']) ? $data['swatch_type'] : '';

            $swatch_value = [];
            if (isset($data['options']) && $data['options']) {
                $options = $this->manageAttribnuteOptions($data);

                $data['options'] = (isset($options['options']) && $options['options']) ? $options['options'] : [];
                $swatch_value = (isset($options['swatch_value']) && $options['swatch_value']) ? $options['swatch_value'] : [];
            }

            $data['is_user_defined'] = 1;

            Event::dispatch('catalog.attribute.update.before', $id);

            $attribute = $this->attributeRepository->update($data, $id);

            if (isset($attribute->id) && $swatch_type == 'image') {

                foreach ($attribute->options as $key => $option) {
                    if (isset($option->admin_name) && isset($swatch_value[$option->admin_name]) && $swatch_value[$option->admin_name]) {
                        bagisto_graphql()->uploadImage($option, $swatch_value[$option->admin_name], 'attribute_option/', 'swatch_value');
                    }
                }
            }

            Event::dispatch('catalog.attribute.update.after', $attribute);

            return $attribute;
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
        if (!isset($args['id']) || (isset($args['id']) && !$args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $id = $args['id'];

        $attribute = $this->attributeRepository->findOrFail($id);

        if (!$attribute->is_user_defined) {
            throw new Exception(trans('admin::app.response.user-define-error', ['name' => 'Attribute']));
        } else {
            try {
                Event::dispatch('catalog.attribute.delete.before', $id);

                $this->attributeRepository->delete($id);

                Event::dispatch('catalog.attribute.delete.after', $id);

                return ['success' => trans('admin::app.response.delete-success', ['name' => 'Attribute'])];
            } catch (\Exception $e) {
                throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Attribute']));
            }
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

            if ((isset($option['admin_name']) && $option['admin_name']) && (isset($option['translations']) && is_array($option['translations']))) {
                $key = strtolower(str_replace(" ", "_", $option['admin_name']));

                if ($attributeOption = $this->attributeOptionRepository->where('admin_name', $option['admin_name'])->first()) {
                    $key = $attributeOption->id;
                }

                $options[$key] = [
                    'admin_name'    => $option['admin_name'],
                    'sort_order'    => isset($option['sort_order']) ? $option['sort_order'] : ($index + 1),
                    'isNew'         => isset($option['isNew']) ? $option["isNew"] : false,
                    'isDelete'      => isset($opfalsetion['isDelete']) ? $option['isDelete'] : false
                ];

                if (isset($option['swatch_value']) && $option['swatch_value']) {
                    if (isset($data['swatch_type']) && $data['swatch_type'] == 'image') {

                        $swatch_value[$option['admin_name']] = $option['swatch_value'];
                        unset($option['swatch_value']);
                    } else {
                        $options[$key]['swatch_value'] = $option['swatch_value'];
                    }
                }

                $localeFields = bagisto_graphql()->manageLocaleFields($option['translations'], ['label']);

                $options[$key] = array_merge($options[$key], $localeFields);
            }
        }

        $response = [
            'options'       => $options,
            'swatch_value'  => $swatch_value
        ];

        return $response;
    }
}
