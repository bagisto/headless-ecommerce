<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Catalog\Products;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Validations\ProductCategoryUniqueSlug;
use Webkul\Core\Rules\Decimal;
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
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'type'                => 'required',
            'attribute_family_id' => 'required',
            'sku'                 => ['required', 'unique:products,sku', new Slug],
        ]);

        if (
            ProductType::hasVariants($args['type'])
            && empty($args['super_attributes'])
        ) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.products.create.configurable-attr-missing'));
        }

        $superAttributes = [];

        if (! empty($args['super_attributes'])) {
            foreach ($args['super_attributes'] as $superAttribute) {
                if (
                    isset($superAttribute['attribute_code'])
                    && isset($superAttribute['values'])
                    && is_array($superAttribute['values'])
                ) {
                    $superAttributes[$superAttribute['attribute_code']] = $superAttribute['values'];
                }
            }
        }

        $args['super_attributes'] = $superAttributes;

        if (ProductType::hasVariants($args['type'])) {
            bagisto_graphql()->validate($args, [
                'super_attributes'     => 'required|array',
                'super_attributes.*'   => 'required|array',
                'super_attributes.*.*' => 'required|exists:attribute_options,id',
            ]);
        }

        try {
            Event::dispatch('catalog.product.create.before');

            $product = $this->productRepository->create($args);

            Event::dispatch('catalog.product.create.after', $product);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.catalog.products.create-success'),
                'product' => $product,
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
        if (! empty($args['custom_attributes'])) {
            foreach ($args['custom_attributes'] as $customAttribute) {
                $args[$customAttribute['name']] = $customAttribute['value'];
            }

            unset($args['custom_attributes']);
        }

        $product = $this->productRepository->find($args['id']);

        if (! $product) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.products.not-found'));
        }

        if (
            $product->type == 'configurable'
            && ! empty($args['variants'])
        ) {
            $args['variants'] = bagisto_graphql()->manageConfigurableRequest($args);
        }

        if ($product->type == 'booking') {
            if (! empty($args['booking'])) {
                $args['booking'] = bagisto_graphql()->manageBookingRequest($product, $args['booking']);
            }
        }

        if (
            $product->type == 'grouped'
            && ! empty($args['links'])
        ) {
            foreach ($args['links'] as $linkProduct) {
                $productLink = $this->productRepository->find($linkProduct['associated_product_id']);

                if (
                    $productLink
                    && $productLink->type != 'simple'
                ) {
                    throw new CustomException(trans('bagisto_graphql::app.admin.catalog.products.simple-products-error'));
                }
            }

            $args['links'] = bagisto_graphql()->manageGroupedRequest($product, $args);
        }

        if ($product->type == 'downloadable') {
            if (! empty($args['downloadable_links'])) {
                $args['downloadable_links'] = bagisto_graphql()->manageDownloadableLinksRequest($product, $args);
            }

            if (! empty($args['downloadable_samples'])) {
                $args['downloadable_samples'] = bagisto_graphql()->manageDownloadableSamplesRequest($product, $args);
            }
        }

        if (
            $product->type == 'bundle'
            && ! empty($args['bundle_options'])
        ) {
            foreach ($args['bundle_options'] as $bundleProduct) {
                foreach ($bundleProduct['products'] as $prod) {
                    $productLink = $this->productRepository->findOrFail($prod['product_id']);

                    if (
                        $productLink
                        && $productLink->type != 'simple'
                    ) {
                        throw new CustomException(trans('bagisto_graphql::app.admin.catalog.products.simple-products-error'));
                    }
                }
            }

            $args['bundle_options'] = bagisto_graphql()->manageBundleRequest($product, $args);
        }

        if (! empty($args['customer_group_prices'])) {
            $args['customer_group_prices'] = bagisto_graphql()->manageCustomerGroupPrices($product, $args);
        }

        if (! empty($args['customizable_options'])) {
            $args['customizable_options'] = bagisto_graphql()->manageCustomizableOptions($product, $args);
        }

        $validator = $this->validateFormData($args['id'], $args);

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
                if (! isset($args[$multiselectAttributeCode])) {
                    $args[$multiselectAttributeCode] = [];
                }
            }
        }

        $imageUrls = $videoUrls = [];

        if (isset($args['images'])) {
            $imageUrls = $args['images'];

            unset($args['images']);
        }

        if (isset($args['videos'])) {
            $videoUrls = $args['videos'];

            unset($args['videos']);
        }

        if (
            $product->type == 'downloadable'
            && isset($args['inventories'])
        ) {
            unset($args['inventories']);
        }

        if (
            ($args['manage_stock'] ?? null) === false
            && isset($args['inventories'])
        ) {
            unset($args['inventories']);
        }

        $inventories = [];

        if (isset($args['inventories'])) {
            foreach ($args['inventories'] as $inventory) {
                if (
                    isset($inventory['inventory_source_id'])
                    && isset($inventory['qty'])
                ) {
                    $inventories[$inventory['inventory_source_id']] = $inventory['qty'];
                }
            }

            $args['inventories'] = $inventories;
        }

        try {
            Event::dispatch('catalog.product.update.before', $product->id);

            $product = $this->productRepository->update($args, $product->id);

            Event::dispatch('catalog.product.update.after', $product);

            if ($product) {
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
            }

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.catalog.products.update-success'),
                'product' => $product,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Validate form data
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validateFormData(int $id, array $data)
    {
        $product = $this->productRepository->findOrFail($id);

        $validateRules = array_merge($product->getTypeInstance()->getTypeValidationRules(), [
            'sku'                => ['required', 'unique:products,sku,'.$id, new Slug],
            'url_key'            => ['required', new ProductCategoryUniqueSlug('products', $id)],
            'special_price_from' => 'nullable|date',
            'special_price_to'   => 'nullable|date|after_or_equal:special_price_from',
            'special_price'      => ['nullable', new Decimal, 'lt:price'],
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
                        ? new Decimal
                        : $attribute->validation
                );
            }

            if ($attribute->type == 'price') {
                array_push($validations, new Decimal);
            }

            if ($attribute->is_unique) {
                array_push($validations, function ($field, $value, $fail) use ($attribute, $id, $data) {
                    $column = ProductAttributeValue::$attributeTypeFields[$attribute->type];

                    if (! $this->productAttributeValueRepository->isValueUnique($id, $attribute->id, $column, $data[$attribute->code])) {
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
     * @return array
     *
     * @throws CustomException
     */
    public function delete(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $product = $this->productRepository->find($args['id']);

        if (! $product) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.products.not-found'));
        }

        try {
            Event::dispatch('catalog.product.delete.before', $args['id']);

            $product->delete();

            Event::dispatch('catalog.product.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.catalog.products.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
