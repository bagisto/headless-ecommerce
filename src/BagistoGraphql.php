<?php

namespace Webkul\GraphQLAPI;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Product\Repositories\ProductBundleOptionProductRepository;
use Webkul\Product\Repositories\ProductBundleOptionRepository;
use Webkul\Product\Repositories\ProductCustomerGroupPriceRepository;
use Webkul\Product\Repositories\ProductDownloadableLinkRepository;
use Webkul\Product\Repositories\ProductDownloadableSampleRepository;
use Webkul\Product\Repositories\ProductGroupedProductRepository;
use Webkul\Product\Repositories\ProductImageRepository;
use Webkul\Product\Repositories\ProductVideoRepository;

class BagistoGraphql
{
    /**
     * allowedImageMimeTypes array
     */
    protected $allowedImageMimeTypes = [
        'png'  => 'image/png',
        'jpe'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg'  => 'image/jpeg',
        'bmp'  => 'image/bmp',
        'webp' => 'image/webp',
    ];

    /**
     * allowedVideoTypes array
     */
    protected $allowedVideoMimeTypes = [
        'mp4'          => 'video/mp4',
        'webm'         => 'video/webm',
        'quicktime'    => 'video/quicktime',
        'octet-stream' => 'application/octet-stream',
    ];

    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct(
        protected ProductBundleOptionRepository $productBundleOptionRepository,
        protected ProductBundleOptionProductRepository $productBundleOptionProductRepository,
        protected ProductCustomerGroupPriceRepository $productCustomerGroupPriceRepository,
        protected ProductDownloadableLinkRepository $productDownloadableLinkRepository,
        protected ProductDownloadableSampleRepository $productDownloadableSampleRepository,
        protected ProductGroupedProductRepository $productGroupedProductRepository,
        protected ProductImageRepository $productImageRepository,
        protected ProductVideoRepository $productVideoRepository
    ) {}

    /**
     * @param  mixed  $validator
     * @return void
     */
    public function checkValidatorFails($validator)
    {
        if ($validator->fails()) {
            $errorMessage = [];

            foreach ($validator->messages()->toArray() as $field => $message) {
                $errorMessage[] = is_array($message) ? $field.': '.$message[0] : $field.': '.$message;
            }

            throw new CustomException(implode(', ', $errorMessage));
        }
    }

    /**
     * To save image through url
     *
     * @param  model  $model
     * @param  string|null  $image_url
     * @param  string  $path
     * @param  string  $type
     * @return mixed
     */
    public function uploadImage($model, $imageUrl, $path, $type)
    {
        $modelPath = $path.$model->id.'/';

        $imageDirPath = storage_path('app/public/'.$modelPath);

        if (! file_exists($imageDirPath)) {
            mkdir(storage_path('app/public/'.$modelPath), 0777, true);
        }

        if (! empty($imageUrl)) {
            $validatedImg = $this->validatePath($imageUrl, 'images');

            if ($validatedImg) {
                $imgName = basename($imageUrl);

                $savePath = $imageDirPath.$imgName;

                if (file_exists($savePath)) {
                    Storage::delete('/'.$modelPath.$imgName);
                }

                file_put_contents($savePath, file_get_contents($imageUrl));

                $model->{$type} = $modelPath.$imgName;

                $model->save();
            }
        }
    }

    /**
     * Store/Update the product images/videos.
     *
     * @param  array  $data
     * @return void
     */
    public function uploadProductImages($data)
    {
        $modelPath = $data['path'].$data['resource']->id.'/';

        $imageDirPath = storage_path('app/public/'.$modelPath);

        if (! file_exists($imageDirPath)) {
            mkdir(storage_path('app/public/'.$modelPath), 0777, true);
        }

        $previousImageIds = $productImageArray = ($data['data_type'] == 'videos') ? $data['resource']->videos()->pluck('id') : $data['resource']->images()->pluck('id');

        if ($data['data']) {

            foreach ($productImageArray->toArray() as $productImageId) {

                if (is_numeric($index = $previousImageIds->search($productImageId))) {
                    $previousImageIds->forget($index);
                }

                if ($data['data_type'] == 'videos') {
                    $this->productVideoRepository->delete($productImageId);
                } else {
                    $this->productImageRepository->delete($productImageId);
                }
            }

            foreach ($data['data'] as $imageId => $imageUrl) {
                $pathValidate = false;

                $imgName = basename($imageUrl);

                if ($data['upload_type'] == 'base64') {

                    $validate = explode('base64,', $imageUrl);

                    if (
                        ! isset($validate[1])
                        || ($this->isNotBase64($validate[1]))
                    ) {
                        continue;
                    }

                    $allowedMimeTypes = $data['data_type'] == 'images' ? $this->allowedImageMimeTypes : $this->allowedVideoMimeTypes;

                    $getImgMime = mime_content_type($imageUrl);

                    $extension = explode('/', $getImgMime)[1];

                    $imgName = Str::random(30).'.'.$extension;

                    $pathValidate = ($getImgMime && in_array($getImgMime, $allowedMimeTypes));
                } else {
                    $pathValidate = $this->validatePath($imageUrl, $data['data_type']);
                }

                if (! $pathValidate) {
                    continue;
                }

                $savePath = $imageDirPath.$imgName;

                if (file_exists($savePath)) {
                    Storage::delete('/'.$modelPath.$imgName);
                }

                file_put_contents($savePath, file_get_contents($imageUrl));

                $params = [
                    'type'       => $data['data_type'],
                    'path'       => $modelPath.$imgName,
                    'product_id' => $data['resource']->id,
                ];

                if ($data['data_type'] == 'videos') {
                    $this->productVideoRepository->create($params);
                } else {
                    $this->productImageRepository->create($params);
                }
            }
        } else {
            foreach ($previousImageIds as $imageId) {
                if ($imageModel = $this->productImageRepository->find($imageId)) {
                    Storage::delete($imageModel->path);

                    if ($data['data_type'] == 'videos') {
                        $this->productImageRepository->delete($imageId);
                    } else {
                        $this->productVideoRepository->delete($imageId);
                    }
                }
            }
        }
    }

    /**
     * To validate the base64 url
     *
     * @param  string|null  $imageURL
     * @param  string|null  $type
     * @return bool
     */
    public function isNotBase64($string)
    {
        return ! preg_match('/^[a-zA-Z0-9\/+]+={0,2}$/', $string) || base64_encode(base64_decode($string)) !== $string;
    }

    /**
     * format customer group prices
     *
     * @param  array  $product
     * @param  array  $data
     * @return array|null
     */
    public function manageCustomerGroupPrices($product, $data)
    {
        $customerGroupPrices = [];

        $previousCustomerGroupPriceIds = $customerGroupPriceArray = $product->customer_group_prices()->pluck('id');

        foreach ($customerGroupPriceArray->toArray() as $key => $customerGroupPriceId) {

            if (is_numeric($index = $previousCustomerGroupPriceIds->search($customerGroupPriceId))) {
                $previousCustomerGroupPriceIds->forget($index);
            }

            $this->productCustomerGroupPriceRepository->delete($customerGroupPriceId);
        }

        foreach ($data['customer_group_prices'] as $key => $row) {
            $row['customer_group_id'] = $row['customer_group_id'] == '' ? null : $row['customer_group_id'];

            $index = 'customer_group_price_'.$key;

            $customerGroupPrices[$index] = $row;
        }

        return $customerGroupPrices;
    }

    /**
     * to manage the translation the multilocal fields
     *
     * @param  array  $data
     * @param  array  $fields
     * @return array|null
     */
    public function manageLocaleFields($data, $fields)
    {
        $result = [];

        foreach ($data as $localeArray) {
            if (! empty($localeArray['code'])) {
                foreach ($fields as $field) {
                    if (! empty($localeArray[$field])) {
                        if (! isset($result[$localeArray['code']][$field])) {
                            $result[$localeArray['code']][$field] = $localeArray[$field];
                        }
                    }
                }
            }
        }

        return $result;
    }

    /**
     * format the request data for Configurable product
     *
     * @param  array  $data
     * @return mixed
     */
    public function manageConfigurableRequest($data)
    {
        $variants = [];

        foreach ($data['variants'] as $variant) {
            if (! empty($variant['variant_id'])) {
                if (! empty($variant['inventories'])) {
                    $inventories = [];

                    foreach ($variant['inventories'] as $inventory) {
                        if (
                            isset($inventory['inventory_source_id'])
                            && isset($inventory['qty'])
                        ) {
                            $inventories[$inventory['inventory_source_id']] = $inventory['qty'];
                        }
                    }

                    $variant['inventories'] = $inventories;
                }

                $variant_id = $variant['variant_id'];

                unset($variant['variant_id']);

                $variants[$variant_id] = $variant;
            }
        }

        return $variants;
    }

    /**
     *to manage the request data for Grouped product
     *
     * @param  array  $data
     * @return mixed
     */
    public function manageGroupedRequest($product, $data)
    {
        $links = [];

        foreach ($data['links'] as $key => $link) {
            if (! empty($link['group_product_id'])) {
                $groupProductId = $link['group_product_id'];

                unset($link['group_product_id']);

                $links[$groupProductId] = $link;
            } else {
                $previousGroupedProductIds = $groupPriceArray = $product->grouped_products()->pluck('id');

                foreach ($groupPriceArray->toArray() as $key => $groupPriceId) {
                    if (is_numeric($index = $previousGroupedProductIds->search($groupPriceId))) {
                        $previousGroupedProductIds->forget($index);
                    }

                    $this->productGroupedProductRepository->delete($groupPriceId);
                }

                if (! empty($link['associated_product_id'])) {
                    $links['link_'.$key] = $link;
                }
            }
        }

        return $links;
    }

    /**
     *to manage the request data for Downloadable's Links
     *
     * @param  array  $data
     * @return mixed
     */
    public function manageDownloadableLinksRequest($product, $data)
    {
        $downloadableLinks = [];

        foreach ($data['downloadable_links'] as $key => $link) {
            if (isset($link['locales'])) {
                foreach ($link['locales'] as $locale) {
                    if (
                        isset($locale['code'])
                        && isset($locale['title'])
                    ) {
                        $link[$locale['code']] = ['title' => $locale['title']];
                    }
                }

                unset($link['locales']);
            }

            if (! empty($link['link_product_id'])) {
                $linkProductId = $link['link_product_id'];

                unset($link['link_product_id']);

                $downloadableLinks[$linkProductId] = $link;
            } else {
                $previousLinkIds = $linkArray = $product->downloadable_links()->pluck('id');

                foreach ($linkArray->toArray() as $key => $linkId) {
                    if (
                        is_numeric($index = $previousLinkIds->search($linkId))
                        && ! isset($downloadableLinks[$linkId])
                    ) {
                        $previousLinkIds->forget($index);
                    }

                    if (! isset($downloadableLinks[$linkId])) {
                        $this->productDownloadableLinkRepository->delete($linkId);
                    }
                }

                if (! empty($link['type'])) {
                    $downloadableLinks['link_'.$key] = $link;
                }
            }
        }

        return $downloadableLinks;
    }

    /**
     *to manage the request data for Downloadable's Sample
     *
     * @param  array  $data
     * @return mixed
     */
    public function manageDownloadableSamplesRequest($product, $data)
    {
        $downloadableSamples = [];

        foreach ($data['downloadable_samples'] as $key => $sample) {
            if (isset($sample['locales'])) {
                foreach ($sample['locales'] as $locale) {
                    if (
                        isset($locale['code'])
                        && isset($locale['title'])
                    ) {
                        $sample[$locale['code']] = ['title' => $locale['title']];
                    }
                }
                unset($sample['locales']);
            }

            if (! empty($sample['sample_product_id'])) {
                $sampleProductId = $sample['sample_product_id'];

                unset($sample['sample_product_id']);

                $downloadableSamples[$sampleProductId] = $sample;
            } else {
                $previousLinkIds = $sampleArray = $product->downloadable_samples()->pluck('id');

                foreach ($sampleArray->toArray() as $key => $sampleId) {
                    if (
                        is_numeric($index = $previousLinkIds->search($sampleId))
                        && ! isset($downloadableSamples[$sampleId])
                    ) {
                        $previousLinkIds->forget($index);
                    }

                    if (! isset($downloadableSamples[$sampleId])) {
                        $this->productDownloadableSampleRepository->delete($sampleId);
                    }
                }

                if (! empty($sample['type'])) {
                    $downloadableSamples['sample_'.$key] = $sample;
                }
            }
        }

        return $downloadableSamples;
    }

    /**
     *to manage the request data for Bundle
     *
     * @param  array  $data
     * @return mixed
     */
    public function manageBundleRequest($product, $data)
    {
        $bundleOptions = [];

        foreach ($data['bundle_options'] as $key => $option) {
            $products = [];

            if (isset($option['locales'])) {
                foreach ($option['locales'] as $locale) {
                    if (
                        isset($locale['code'])
                        && isset($locale['label'])
                    ) {
                        $option[$locale['code']] = ['label' => $locale['label']];
                    }
                }

                unset($option['locales']);
            }

            if (! empty($option['bundle_option_id'])) {
                $bundleOptionId = $option['bundle_option_id'];

                unset($option['bundle_option_id']);

                if (! empty($option['products'])) {
                    foreach ($option['products'] as $index => $prod) {
                        if (! empty($prod['bundle_option_product_id'])) {
                            $bundle_option_product_id = $prod['bundle_option_product_id'];

                            unset($prod['bundle_option_product_id']);

                            $products[$bundle_option_product_id] = $prod;
                        } else {
                            $productBundleOption = $this->productBundleOptionRepository->findOrFail($bundleOptionId);

                            $previousBundleOptionProductIds = $bundleOptionProductArray = $productBundleOption->bundle_option_products()->pluck('id');

                            foreach ($bundleOptionProductArray->toArray() as $key => $bundleOptionProductId) {
                                if (
                                    is_numeric($index = $previousBundleOptionProductIds->search($bundleOptionProductId))
                                    && ! isset($bundleOptions[$bundleOptionProductId])
                                ) {
                                    $previousBundleOptionProductIds->forget($index);
                                }

                                if (! isset($bundleOptions[$bundleOptionProductId])) {
                                    $this->productBundleOptionProductRepository->delete($bundleOptionProductId);
                                }
                            }

                            if (! empty($prod['product_id'])) {
                                $products['product_'.$index] = $prod;
                            }
                        }
                    }

                    $option['products'] = $products;
                }

                $bundleOptions[$bundleOptionId] = $option;
            } else {
                $previousBundleOptionIds = $optionArray = $product->bundle_options()->pluck('id');

                foreach ($optionArray->toArray() as $key => $optionId) {
                    if (
                        is_numeric($index = $previousBundleOptionIds->search($optionId))
                        && ! isset($bundleOptions[$optionId])
                    ) {
                        $previousBundleOptionIds->forget($index);
                    }

                    if (! isset($bundleOptions[$optionId])) {
                        $this->productBundleOptionRepository->delete($optionId);
                    }
                }

                if (! empty($option['products'])) {
                    foreach ($option['products'] as $index => $prod) {
                        if (! empty($prod['product_id'])) {
                            $products['product_'.$index] = $prod;
                        }
                    }

                    $option['products'] = $products;
                }

                if (! empty($option['type'])) {
                    $bundleOptions['option_'.$key] = $option;
                }
            }
        }

        return $bundleOptions;
    }

    /**
     *to manage the request data for Cart
     *
     * @param  object  $product
     * @param  array  $data
     * @return array
     */
    public function manageInputForCart($product, $data)
    {
        switch ($product->type) {
            case 'configurable':
                //Case: In case of configurable product added
                if (! empty($data['super_attribute'])) {
                    $superAttribute = [];

                    foreach ($data['super_attribute'] as $attribute) {
                        if (
                            isset($attribute['attribute_id'])
                            && isset($attribute['attribute_option_id'])
                        ) {
                            $superAttribute[$attribute['attribute_id']] = $attribute['attribute_option_id'];
                        }
                    }
                    $data['super_attribute'] = $superAttribute;
                }
                break;
            case 'grouped':
                //Case: In case of grouped product added
                if (! empty($data['qty'])) {
                    $groupedProduct = [];

                    foreach ($data['qty'] as $product) {
                        if (! empty($product['product_id'])) {
                            $groupedProduct[$product['product_id']] = $product['quantity'];
                        }
                    }

                    $data['qty'] = $groupedProduct;
                }
                break;
            case 'bundle':
                //Case: In case of bundled product added
                if (! empty($data['bundle_options'])) {
                    $bundle_options = [];

                    foreach ($data['bundle_options'] as $option) {
                        if (
                            ! empty($option['bundle_option_id'])
                            && ! empty($option['bundle_option_product_id'])
                        ) {
                            $bundle_options[$option['bundle_option_id']] = $option['bundle_option_product_id'];
                        }
                    }

                    $data['bundle_options'] = $bundle_options;
                }
                break;

            default:
                break;
        }

        return $data;
    }

    /**
     * To save image using path/url/base64
     *
     * @param  mixed  $collection
     * @param  array  $data
     * @param  string  $field
     * @return void
     */
    public function saveImageByURL($collection, $data = [], $field = 'image_url')
    {
        $getImgMime = null;

        $base64OrPathValidate = false;

        $imageName = basename($data[$field]);

        if ($data['upload_type'] == 'base64') {
            $getImgMime = mime_content_type($data[$field]);

            $extension = explode('/', $getImgMime)[1];

            $imageName = $field.'_avatar.'.$extension;

            $base64OrPathValidate = ($getImgMime && in_array($getImgMime, $this->allowedImageMimeTypes));
        } else {
            $base64OrPathValidate = $this->validatePath($data[$field], 'image');
        }

        if ($base64OrPathValidate) {
            $keyIndex = explode('_', $field);

            if (! isset($keyIndex[0])) {
                return false;
            }

            if ($collection->{$keyIndex[0]}) {
                Storage::delete($collection->{$keyIndex[0]});
            }

            $collection->{$keyIndex[0]} = null;

            $collection->save();

            $path = $data['save_path'].'/';

            $contents = file_get_contents($data[$field]);

            Storage::put($path.$imageName, $contents);

            $collection->{$keyIndex[0]} = $path.$imageName;

            $collection->save();
        }
    }

    public function storeReviewAttachment($data = [], $field = 'image_url')
    {
        $getImgMime = null;

        $base64Validate = $pathValidate = false;

        $imageName = basename($data[$field]);

        $getImgMime = mime_content_type($data[$field]);

        $extension = explode('/', $getImgMime)[1];

        $imageName = $imageName.'_review.'.$extension;

        $base64Validate = ($getImgMime && in_array($getImgMime, $this->allowedImageMimeTypes));

        if (
            $base64Validate
            || $pathValidate
        ) {
            $keyIndex = explode('_', $field);

            if (! isset($keyIndex[0])) {
                return false;
            }

            $path = $data['save_path'].'/';

            Storage::put($path.$imageName, file_get_contents($data[$field]));

            return [
                'path'        => $path.$imageName,
                'img_details' => explode('/', mime_content_type($data[$field])),
            ];
        }
    }

    /**
     * To validate the image url
     *
     * @param  string|null  $imageURL
     * @param  string|null  $type
     * @return bool
     */
    public function validatePath(string $imageURL, $type = 'images')
    {
        if (! $imageURL) {
            return false;
        }

        $chkURL = curl_init();

        curl_setopt($chkURL, CURLOPT_URL, $imageURL);
        curl_setopt($chkURL, CURLOPT_NOBODY, 1);
        curl_setopt($chkURL, CURLOPT_FAILONERROR, 1);
        curl_setopt($chkURL, CURLOPT_RETURNTRANSFER, 1);

        if (
            curl_exec($chkURL) !== false
            && $this->getImageMIMEType($imageURL, $type)
        ) {
            return true;
        }

        return false;
    }

    /**
     * To validate the image's mime type
     *
     * @param  string|null  $imageURL
     * @param  string|null  $type
     * @return bool
     */
    public function getImageMIMEType($filename, $type = 'images')
    {
        $ext = strtolower(array_pop(explode('.', $filename)));

        $mimeTypes = $type == 'images'
                        ? $this->allowedImageMimeTypes
                        : $this->allowedVideoMimeTypes;

        if (array_key_exists($ext, $mimeTypes)) {
            return true;
        }

        if (! function_exists('finfo_open')) {
            return false;
        }

        $finfo = finfo_open(FILEINFO_MIME);

        $mimetype = finfo_file($finfo, $filename);

        finfo_close($finfo);

        return $mimetype;
    }
}
