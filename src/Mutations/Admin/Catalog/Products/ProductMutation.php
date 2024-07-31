<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Catalog\Products;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Core\Rules\Slug;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Product\Helpers\ProductType;
use Webkul\Product\Models\ProductAttributeValue;
use Webkul\Product\Repositories\ProductAttributeValueRepository;
use Webkul\Product\Repositories\ProductRepository;

class ProductMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected ProductRepository $productRepository,
        protected ProductAttributeValueRepository $productAttributeValueRepository
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
            'type'                => 'required',
            'attribute_family_id' => 'required',
            'sku'                 => ['required', 'unique:products,sku', new Slug],
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        if (
            ProductType::hasVariants($data['type'])
            && empty($data['super_attributes'])
        ) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.products.create.configurable-error'));
        }

        $super_attributes = [];

        if (! empty($data['super_attributes'])) {
            foreach ($data['super_attributes'] as $super_attribute) {
                if (
                    isset($super_attribute['attribute_code'])
                    && isset($super_attribute['values'])
                    && is_array($super_attribute['values'])
                ) {
                    $super_attributes[$super_attribute['attribute_code']] = $super_attribute['values'];
                }
            }
        }

        $data['super_attributes'] = $super_attributes;

        try {
            Event::dispatch('catalog.product.create.before');

            $product = $this->productRepository->create($data);

            Event::dispatch('catalog.product.create.after', $product);

            return $product;
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

        if (! empty($data['custom_attributes'])) {
            foreach ($data['custom_attributes'] as $customAttribute) {
                $data[$customAttribute['name']] = $customAttribute['value'];
            }

            unset($data['custom_attributes']);
        }

        $product = $this->productRepository->findOrFail($id);

        // Only in case of configurable product type
        if (
            $product->type == 'configurable'
            && ! empty($data['variants'])
        ) {
            $data['variants'] = bagisto_graphql()->manageConfigurableRequest($data);
        }

        // Only in case of grouped product type
        if (
            $product->type == 'grouped'
            && ! empty($data['links'])
        ) {
            foreach ($data['links'] as $linkProduct) {
                $productLink = $this->productRepository->findOrFail($linkProduct['associated_product_id']);

                if (
                    $productLink
                    && $productLink->type != 'simple'
                ) {
                    throw new CustomException("$productLink->type trans('bagisto_graphql::app.admin.catalog.products.create.grouped-error-not-added')");
                }
            }

            $data['links'] = bagisto_graphql()->manageGroupedRequest($product, $data);
        }

        // Only in case of downloadable product type
        if ($product->type == 'downloadable') {
            if (! empty($data['downloadable_links'])) {
                $data['downloadable_links'] = bagisto_graphql()->manageDownloadableLinksRequest($product, $data);
            }

            if (! empty($data['downloadable_samples'])) {
                $data['downloadable_samples'] = bagisto_graphql()->manageDownloadableSamplesRequest($product, $data);
            }
        }

        // Only in case of bundle product type
        if (
            $product->type == 'bundle'
            && ! empty($data['bundle_options'])
        ) {
            foreach ($data['bundle_options'] as $bundleProduct) {
                foreach ($bundleProduct['products'] as $prod) {
                    $productLink = $this->productRepository->findOrFail($prod['product_id']);

                    if (
                        $productLink
                        && $productLink->type != 'simple'
                    ) {
                        throw new CustomException("$productLink->type trans('bagisto_graphql::app.admin.catalog.products.create.bundle-error-not-added')");
                    }
                }
            }

            $data['bundle_options'] = bagisto_graphql()->manageBundleRequest($product, $data);
        }

        // Only in case of customer group price
        if (! empty($data['customer_group_prices'])) {
            $data['customer_group_prices'] = bagisto_graphql()->manageCustomerGroupPrices($product, $data);
        }

        $validator = $this->validateFormData($id, $data);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        $multiselectAttributeCodes = [];

        foreach ($product->attribute_family->attribute_groups as $attributeGroup) {
            $customAttributes = $product->getEditableAttributes($attributeGroup);

            if (! count($customAttributes)) {
                continue;
            }

            foreach ($customAttributes as $attribute) {
                if ($attribute->type == 'multiselect') {
                    array_push($multiselectAttributeCodes, $attribute->code);
                }
            }
        }

        if (count($multiselectAttributeCodes)) {
            foreach ($multiselectAttributeCodes as $multiselectAttributeCode) {
                if (! isset($data[$multiselectAttributeCode])) {
                    $data[$multiselectAttributeCode] = [];
                }
            }
        }

        $imageUrls = $videoUrls = [];

        if (isset($data['images'])) {
            $imageUrls = $data['images'];

            unset($data['images']);
        }

        if (isset($data['videos'])) {
            $videoUrls = $data['videos'];

            unset($data['videos']);
        }

        $inventories = [];

        if (isset($data['inventories'])) {
            foreach ($data['inventories'] as $inventory) {
                if (
                    isset($inventory['inventory_source_id'])
                    && isset($inventory['qty'])
                ) {
                    $inventories[$inventory['inventory_source_id']] = $inventory['qty'];
                }
            }

            $data['inventories'] = $inventories;
        }

        try {
            Event::dispatch('catalog.product.update.before', $id);

            $product = $this->productRepository->update($data, $id);

            Event::dispatch('catalog.product.update.after', $product);

            if (isset($product->id)) {
                $uploadParams = [
                    'resource'    => $product,
                    'data'        => $imageUrls,
                    'path'        => 'product/',
                    'data_type'   => 'images',
                    'upload_type' => $args['upload_type'] ?? 'path',
                ];

                bagisto_graphql()->uploadProductImages($uploadParams);

                bagisto_graphql()->uploadProductImages(array_merge($uploadParams, [
                    'data'      => $videoUrls,
                    'data_type' => 'videos',
                ]));

                return $product;
            }
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    public function validateFormData($id, $data)
    {
        $product = $this->productRepository->findOrFail($id);

        $validateRules = array_merge($product->getTypeInstance()->getTypeValidationRules(), [
            'sku'                => ['required', 'unique:products,sku,'.$id, new \Webkul\Core\Rules\Slug],
            // 'images.*'           => 'nullable|mimes:jpeg,jpg,bmp,png',
            'special_price_from' => 'nullable|date',
            'special_price_to'   => 'nullable|date|after_or_equal:special_price_from',
            'special_price'      => ['nullable', new \Webkul\Core\Rules\Decimal, 'lt:price'],
        ]);

        foreach ($product->getEditableAttributes() as $attribute) {
            if (
                $attribute->code == 'sku'
                || $attribute->type == 'boolean'
            ) {
                continue;
            }

            $validations = [];

            if (! isset($validateRules[$attribute->code])) {
                array_push($validations, $attribute->is_required ? 'required' : 'nullable');
            } else {
                $validations = $validateRules[$attribute->code];
            }

            if (
                $attribute->type == 'text'
                && $attribute->validation
            ) {
                array_push(
                    $validations,
                    $attribute->validation == 'decimal'
                        ? new \Webkul\Core\Rules\Decimal
                        : $attribute->validation
                );
            }

            if ($attribute->type == 'price') {
                array_push($validations, new \Webkul\Core\Rules\Decimal);
            }

            if ($attribute->is_unique) {
                array_push($validations, function ($field, $value, $fail) use ($attribute, $id) {
                    $column = ProductAttributeValue::$attributeTypeFields[$attribute->type];

                    if (! $this->productAttributeValueRepository->isValueUnique($id, $attribute->id, $column, request($attribute->code))) {
                        $fail('The :attribute has already been taken.');
                    }
                });
            }

            $validateRules[$attribute->code] = $validations;
        }

        return Validator::make($data, $validateRules);
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

        $this->productRepository->findOrFail($args['id']);

        try {
            $this->productRepository->delete($args['id']);

            return ['success' => trans('bagisto_graphql::app.admin.catalog.products.delete-success')];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
