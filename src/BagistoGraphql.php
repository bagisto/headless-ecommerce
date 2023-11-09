<?php

namespace Webkul\GraphQLAPI;

use Illuminate\Support\Arr;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Webkul\Product\Repositories\ProductImageRepository;
use Webkul\Product\Repositories\ProductVideoRepository;
use Webkul\Product\Repositories\ProductCustomerGroupPriceRepository;
use Webkul\Product\Repositories\ProductGroupedProductRepository;
use Webkul\Product\Repositories\ProductDownloadableLinkRepository;
use Webkul\Product\Repositories\ProductDownloadableSampleRepository;
use Webkul\Product\Repositories\ProductBundleOptionRepository;
use Webkul\Product\Repositories\ProductBundleOptionProductRepository;

class BagistoGraphql
{
    /**
     * allowedImageMimeTypes array
     *
     */
    protected $allowedImageMimeTypes = [
        'png'   => 'image/png',
        'jpe'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'jpg'   => 'image/jpeg',
        'bmp'   => 'image/bmp',
        'webp'  => 'image/webp',
    ];

    protected $allowedVideoMimeTypes = [
        'mp4'       => 'video/mp4',
        'webm'      => 'video/webm',
        'quicktime' => 'video/quicktime',
        'octet-stream' => 'application/octet-stream',
    ];

    /**
     * Create a new instance.
     *
     * @param  \Webkul\Product\Repositories\ProductImageRepository  $productImageRepository
     * @param  \Webkul\Product\Repositories\ProductVideoRepository  $productVideoRepository
     * @param  \Webkul\Product\Repositories\ProductCustomerGroupPriceRepository  $productCustomerGroupPriceRepository
     * @param  \Webkul\Product\Repositories\ProductGroupedProductRepository $productGroupedProductRepository
     * @param  \Webkul\Product\Repositories\ProductDownloadableLinkRepository $productDownloadableLinkRepository
     * @param  \Webkul\Product\Repositories\ProductDownloadableSampleRepository $productDownloadableSampleRepository
     * @param  \Webkul\Product\Repositories\ProductBundleOptionRepository $productBundleOptionRepository
     * @param  \Webkul\Product\Repositories\ProductBundleOptionProductRepository $productBundleOptionProductRepository
     *
     * @return void
     */
    public function __construct(
        protected ProductCustomerGroupPriceRepository $productCustomerGroupPriceRepository,
        protected ProductGroupedProductRepository $productGroupedProductRepository,
        protected ProductDownloadableLinkRepository $productDownloadableLinkRepository,
        protected ProductDownloadableSampleRepository $productDownloadableSampleRepository,
        protected ProductBundleOptionRepository $productBundleOptionRepository,
        protected ProductBundleOptionProductRepository $productBundleOptionProductRepository,
        protected ProductImageRepository $productImageRepository,
        protected ProductVideoRepository $productVideoRepository
    )   {
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard($guard)
    {
        return Auth::guard($guard);
    }

    /**
     * Validate header in Post APIs
     *
     * @param guard $value
     * @return boolean
    */
    public function validateAPIUser($guard)
    {
        $token = 0;

        if (request()->hasHeader('authorization')) {
            $headerValue = explode("Bearer ", request()->header('authorization'));

            if (isset($headerValue[1]) && $headerValue[1]) {
                $token = $headerValue[1];
            }
        }

        $validateUser = $this->apiAuth($token, $guard);

        return (! $token || (! isset($validateUser['success']) || (isset($validateUser['success']) && ! $validateUser['success'])))
            ? false
            : true;
    }

    /**
     * Add Admin/Customer API Guard and JWT
     *
     * @param data $value
     * @return mixed
    */
    public function apiAuth($token, $guard)
    {
        $loggedAdmin = auth($guard)->user();

        try {
            $setToken =  JWTAuth::setToken($token)->authenticate();
            $customerFromToken = JWTAuth::toUser($setToken);

            if (isset($setToken) && isset($customerFromToken) && $loggedAdmin != NULL) {
                if ($customerFromToken->id == $loggedAdmin->id) {
                    return [
                        'success'   => true,
                        'message'   => trans('bagisto_graphql::app.admin.response.success-login'),
                    ];
                }
            } else {
                return [
                    'success'   => false,
                    'message'   => trans('bagisto_graphql::app.admin.response.error-login'),
                ];
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return [
                'success'   => false,
                'message'   => $e->getMessage(),
            ];
        } catch (\Exception $e) {
            //In case customer's session has expired
            if ( $token !== 0 && $loggedAdmin == null ) {
                return [
                    'success'       => false,
                    'message'       => trans('bagisto_graphql::app.admin.response.session-expired'),
                    'otherError'    => 'userNotExist'
                ];
            } else {
                return [
                    'success'   => false,
                    'message'   => $e->getMessage(),
                ];
            }
        }
    }

    /**
     * To save image through url
     *
     * @param model $model
     * @param String|null $image_url
     * @param String $path
     * @param String $type
     * @return mixed
    */
    public function uploadImage($model, $image_url, $path, $type)
    {
        $model_path = $path . $model->id . '/';
        $image_dir_path = storage_path('app/public/' . $model_path);
        if (! file_exists($image_dir_path)) {
            mkdir(storage_path('app/public/' . $model_path), 0777, true);
        }

        if ( isset($image_url) && $image_url) {
            $valoidateImg = $this->validatePath($image_url, 'image');

            if ( $valoidateImg ) {
                $img_name = basename($image_url);
                $savePath = $image_dir_path . $img_name;

                if ( file_exists($savePath) ) {
                    Storage::delete('/' . $model_path . $img_name);
                }

                file_put_contents($savePath, file_get_contents($image_url));

                $model->{$type} = $model_path . $img_name;

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
        $model_path = $data['path'] . $data['resource']->id . '/';

        $image_dir_path = storage_path('app/public/' . $model_path);

        if (! file_exists($image_dir_path)) {
            mkdir(storage_path('app/public/' . $model_path), 0777, true);
        }

        $previousImageIds = $productImageArray = ($data['data_type'] == 'video') ? $data['resource']->videos()->pluck('id') : $data['resource']->images()->pluck('id');

        if ($data['data']) {

            foreach ($productImageArray->toArray() as $productImageId) {

                if (is_numeric($index = $previousImageIds->search($productImageId))) {
                    $previousImageIds->forget($index);
                }

                if ( $data['data_type'] == 'video')
                    $this->productVideoRepository->delete($productImageId);
                else
                    $this->productImageRepository->delete($productImageId);
            }

            foreach ($data['data'] as $imageId => $image_url) {
                
                $pathValidate = false;
                $img_name = basename($image_url);

                if ($data['upload_type'] == 'base64') {
                    
                    $validate = explode("base64,", $image_url);

                    if (
                        ! isset($validate[1]) 
                        || ($this->is_not_base64($validate[1]))
                    ) {
                        continue;
                    }

                    $allowedMimeTypes = $data['data_type'] == 'image' ? $this->allowedImageMimeTypes : $this->allowedVideoMimeTypes;

                    $getImgMime = mime_content_type($image_url);
            
                    $extension = explode("/", $getImgMime)[1];
                
                    $img_name = \Str::random(30) . '.' . $extension;

                    $pathValidate = ($getImgMime && in_array($getImgMime, $allowedMimeTypes));
                } else {
                    $pathValidate = $this->validatePath($image_url, $data['data_type']);
                }

                if (! $pathValidate) {
                    continue;
                }

                $savePath = $image_dir_path . $img_name;

                if (file_exists($savePath)) {
                    Storage::delete('/' . $model_path . $img_name);
                }

                file_put_contents($savePath, file_get_contents($image_url));

                $params =[
                    'type'       => $data['data_type'],
                    'path'       => $model_path . $img_name,
                    'product_id' => $data['resource']->id,
                ];

                if ( $data['data_type'] == 'video') {
                    $this->productVideoRepository->create($params);
                } else {
                    $this->productImageRepository->create($params);
                }
            }
        } else {
            foreach ($previousImageIds as $imageId) {
                if ($imageModel = $this->productImageRepository->find($imageId)) {
                    Storage::delete($imageModel->path);

                    if ( $data['data_type'] == 'video')
                        $this->productImageRepository->delete($imageId);
                    else
                        $this->productVideoRepository->delete($imageId);
                }
            }
        }
    }

    /**
     * To validate the base64 url
     *
     * @param String|null $imageURL
     * @param String|null $type
     * @return boolean
     */
    function is_not_base64($string) {
        return !preg_match('/^[a-zA-Z0-9\/+]+={0,2}$/', $string) || base64_encode(base64_decode($string)) !== $string;
    }

    /**
     * To validate the image url
     *
     * @param String|null $imageURL
     * @param String|null $type
     * @return boolean
    */
    public function validatePath(string $imageURL, $type = 'image') {
        if ($imageURL) {
            $chkURL = curl_init();
			curl_setopt($chkURL, CURLOPT_URL, $imageURL);
			curl_setopt($chkURL, CURLOPT_NOBODY, 1);
			curl_setopt($chkURL, CURLOPT_FAILONERROR, 1);
			curl_setopt($chkURL, CURLOPT_RETURNTRANSFER, 1);
			if (curl_exec($chkURL) !== FALSE && $this->getImageMIMEType($imageURL, $type)) {
					return true;
			} else {
					return false;
			}
        } else {
            return false;
        }
    }

    /**
     * To validate the image's mime type
     *
     * @param String|null $imageURL
     * @param String|null $type
     * @return boolean
    */
    public function getImageMIMEType($filename, $type = 'image')
    {
        $explodeURL = explode('.', $filename);
        $ext = strtolower(array_pop($explodeURL));

        $mimeTypes = $type == 'image' ? $this->allowedImageMimeTypes : $this->allowedVideoMimeTypes;

        if (array_key_exists($ext, $mimeTypes)) {
            return true;
        } elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        } else {
            return false;
        }
    }

    /**
     * format customer group prices
     *
     * @param array $product
     * @param array $data
     * @return array|null
    */
    public function manageCustomerGroupPrices($product, $data)
    {
        $customer_group_prices = [];

        $previousCustomerGroupPriceIds = $customerGroupPriceArray = $product->customer_group_prices()->pluck('id');

        foreach ($customerGroupPriceArray->toArray() as $key => $customerGroupPriceId) {

            if (is_numeric($index = $previousCustomerGroupPriceIds->search($customerGroupPriceId))) {
                $previousCustomerGroupPriceIds->forget($index);
            }

            $this->productCustomerGroupPriceRepository->delete($customerGroupPriceId);
        }

        foreach ($data['customer_group_prices'] as $key => $row) {
            $row['customer_group_id'] = $row['customer_group_id'] == '' ? null : $row['customer_group_id'];
            $index = 'customer_group_price_' . $key;
            $customer_group_prices[$index] = $row;
        }

        return $customer_group_prices;
    }

    /**
     * to manage the translation the multilocal fields
     *
     * @param array $data
     * @param array $fields
     * @return array|null
    */
    public function manageLocaleFields($data, $fields)
    {
        $result = [];

        foreach ($data as $localeArray) {
            if ( isset($localeArray['code']) && $localeArray['code'] ) {

                foreach ($fields as $field) {
                    if ( isset($localeArray[$field]) && $localeArray[$field] ) {

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
     * @param array $data
     * @return mixed
    */
    public function manageConfigurableRequest($data)
    {
        $variants = [];
        foreach ($data['variants'] as $key => $variant) {
            if ( isset($variant['variant_id']) && $variant['variant_id']) {
                if ( isset($variant['inventories']) && $variant['inventories'] ) {

                    $inventories = [];
                    foreach ($variant['inventories'] as $key => $inventory) {
                        if ( isset($inventory['inventory_source_id']) && isset($inventory['qty']) ) {
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
     * @param array $data
     * @return mixed
    */
    public function manageGroupedRequest($product, $data)
    {
        $links = [];
        foreach ($data['links'] as $key => $link) {
            if ( isset($link['group_product_id']) && $link['group_product_id']) {
                $group_product_id = $link['group_product_id'];
                unset($link['group_product_id']);

                $links[$group_product_id] = $link;
            } else {
                $previousGroupedProductIds = $groupPriceArray = $product->grouped_products()->pluck('id');

                foreach ($groupPriceArray->toArray() as $key => $groupPriceId) {
                    if (is_numeric($index = $previousGroupedProductIds->search($groupPriceId))) {
                        $previousGroupedProductIds->forget($index);
                    }

                    $this->productGroupedProductRepository->delete($groupPriceId);
                }

                if ( isset($link['associated_product_id']) && $link['associated_product_id']) {
                    $links['link_' . $key] = $link;
                }
            }
        }

        return $links;
    }

    /**
     *to manage the request data for Downloadable's Links
     *
     * @param array $data
     * @return mixed
    */
    public function manageDownloadableLinksRequest($product, $data)
    {
        $downloadable_links = [];
        foreach ($data['downloadable_links'] as $key => $link) {

            if (isset($link['locales'])) {
                foreach ($link['locales'] as $locale) {
                    if ( isset($locale['code']) && isset($locale['title'])) {
                        $link[$locale['code']] = ['title' => $locale['title']];
                    }
                }
                unset($link['locales']);
            }

            if ( isset($link['link_product_id']) && $link['link_product_id']) {
                $link_product_id = $link['link_product_id'];
                unset($link['link_product_id']);

                $downloadable_links[$link_product_id] = $link;
            } else {
                $previousLinkIds = $linkArray = $product->downloadable_links()->pluck('id');

                foreach ($linkArray->toArray() as $key => $linkId) {
                    if (is_numeric($index = $previousLinkIds->search($linkId))) {
                        if (! isset($downloadable_links[$linkId])) {
                            $previousLinkIds->forget($index);
                        }
                    }

                    if (! isset($downloadable_links[$linkId])) {
                        $this->productDownloadableLinkRepository->delete($linkId);
                    }
                }

                if ( isset($link['type']) && $link['type']) {
                    $downloadable_links['link_' . $key] = $link;
                }
            }
        }

        return $downloadable_links;
    }

    /**
     *to manage the request data for Downloadable's Sample
     *
     * @param array $data
     * @return mixed
    */
    public function manageDownloadableSamplesRequest($product, $data)
    {
        $downloadable_samples = [];
        foreach ($data['downloadable_samples'] as $key => $sample) {

            if (isset($sample['locales'])) {
                foreach ($sample['locales'] as $locale) {
                    if ( isset($locale['code']) && isset($locale['title'])) {
                        $sample[$locale['code']] = ['title' => $locale['title']];
                    }
                }
                unset($sample['locales']);
            }

            if ( isset($sample['sample_product_id']) && $sample['sample_product_id']) {
                $sample_product_id = $sample['sample_product_id'];
                unset($sample['sample_product_id']);

                $downloadable_samples[$sample_product_id] = $sample;
            } else {
                $previousLinkIds = $sampleArray = $product->downloadable_samples()->pluck('id');

                foreach ($sampleArray->toArray() as $key => $sampleId) {
                    if (is_numeric($index = $previousLinkIds->search($sampleId))) {
                        if (! isset($downloadable_samples[$sampleId])) {
                            $previousLinkIds->forget($index);
                        }
                    }
                    if (! isset($downloadable_samples[$sampleId])) {
                        $this->productDownloadableSampleRepository->delete($sampleId);
                    }
                }

                if ( isset($sample['type']) && $sample['type']) {
                    $downloadable_samples['sample_' . $key] = $sample;
                }
            }
        }

        return $downloadable_samples;
    }

    /**
     *to manage the request data for Bundle
     *
     * @param array $data
     * @return mixed
    */
    public function manageBundleRequest($product, $data)
    {
        $bundle_options = [];
        foreach ($data['bundle_options'] as $key => $option) {
            $products = [];

            if (isset($option['locales'])) {
                foreach ($option['locales'] as $locale) {
                    if ( isset($locale['code']) && isset($locale['label'])) {
                        $option[$locale['code']] = ['label' => $locale['label']];
                    }
                }
                unset($option['locales']);
            }

            if ( isset($option['bundle_option_id']) && $option['bundle_option_id']) {
                $bundle_option_id = $option['bundle_option_id'];
                unset($option['bundle_option_id']);

                if ( isset($option['products']) && $option['products']) {
                    foreach($option['products'] as $index => $prod) {

                        if ( isset($prod['bundle_option_product_id']) && $prod['bundle_option_product_id']) {

                            $bundle_option_product_id = $prod['bundle_option_product_id'];
                            unset($prod['bundle_option_product_id']);

                            $products[$bundle_option_product_id] = $prod;
                        } else {
                            $productBundleOption = $this->productBundleOptionRepository->findOrFail($bundle_option_id);

                            $previousBundleOptionProductIds = $bundleOptionProductArray = $productBundleOption->bundle_option_products()->pluck('id');

                            foreach ($bundleOptionProductArray->toArray() as $key => $bundleOptionProductId) {
                                if (is_numeric($index = $previousBundleOptionProductIds->search($bundleOptionProductId))) {
                                    if (! isset($bundle_options[$bundleOptionProductId])) {
                                        $previousBundleOptionProductIds->forget($index);
                                    }
                                }
                                if (! isset($bundle_options[$bundleOptionProductId])) {
                                    $this->productBundleOptionProductRepository->delete($bundleOptionProductId);
                                }
                            }

                            if ( isset($prod['product_id']) && $prod['product_id']) {
                                $products['product_' . $index] = $prod;
                            }
                        }
                    }

                    $option['products'] = $products;
                }

                $bundle_options[$bundle_option_id] = $option;
            } else {
                $previousBundleOptionIds = $optionArray = $product->bundle_options()->pluck('id');

                foreach ($optionArray->toArray() as $key => $optionId) {
                    if (is_numeric($index = $previousBundleOptionIds->search($optionId))) {
                        if (! isset($bundle_options[$optionId])) {
                            $previousBundleOptionIds->forget($index);
                        }
                    }
                    if (! isset($bundle_options[$optionId])) {
                        $this->productBundleOptionRepository->delete($optionId);
                    }
                }

                if ( isset($option['products']) && $option['products']) {
                    foreach($option['products'] as $index => $prod) {
                        if ( isset($prod['product_id']) && $prod['product_id']) {
                            $products['product_' . $index] = $prod;
                        }
                    }
                    $option['products'] = $products;
                }

                if ( isset($option['type']) && $option['type']) {
                    $bundle_options['option_' . $key] = $option;
                }
            }
        }

        return $bundle_options;
    }

    /**
     *to manage the request data for Booking
     *
     * @param array $data
     * @return mixed
    */
    public function manageBookingRequest($data)
    {
        $booking = [];
        switch ($data['type']) {
            case 'appointment':
                if ( isset($data['same_slot_all_days']) && !$data['same_slot_all_days']) {
                    $slots = [];
                    if ( isset($data['slots'])) {
                        foreach ($data['slots'] as $key => $slot) {
                            if ( isset($slot['day'])) {
                                $day_index = $slot['day'];
                                unset($slot['day']);

                                $slots[$day_index][] = $slot;
                            }
                        }

                        $data['slots'] = $slots;
                        $booking = $data;
                    }
                } else {
                    $booking = $data;
                }
                break;

            case 'event':
                if ( isset($data['tickets']) && $data['tickets']) {
                    $tickets = [];

                    foreach ($data['tickets'] as $key => $ticket) {

                        if (isset($ticket['locales'])) {
                            foreach($ticket['locales'] as $locale) {
                                $locale_code = $locale['locale'];
                                unset($locale['locale']);
                                $ticket[$locale_code] = $locale;
                            }

                            unset($ticket['locales']);
                        }
                        $tickets['ticket_' . $key] = $ticket;
                    }
                    $data['tickets'] = $tickets;
                }

                $booking = $data;
                break;
            case 'rental':
                if ( isset($data['rental_slot']) && $data['rental_slot']) {

                    foreach ($data['rental_slot'] as $key => $slot) {
                        $data[$key] = $slot;
                    }
                    unset($data['rental_slot']);

                    if ( isset($data['same_slot_all_days']) && !$data['same_slot_all_days']) {
                        $slots = [];
                        if ( isset($data['slots'])) {
                            foreach ($data['slots'] as $key => $slot) {
                                if ( isset($slot['day'])) {
                                    $day_index = $slot['day'];
                                    unset($slot['day']);

                                    $slots[$day_index][] = $slot;
                                }
                            }

                            $data['slots'] = $slots;
                            $booking = $data;
                        }
                    } else {
                        $booking = $data;
                    }
                }
                break;
            case 'table':
                if ( isset($data['table_slot']) && $data['table_slot']) {

                    foreach ($data['table_slot'] as $key => $slot) {
                        $data[$key] = $slot;
                    }
                    unset($data['table_slot']);

                    if ( isset($data['same_slot_all_days']) && !$data['same_slot_all_days']) {
                        $slots = [];
                        if ( isset($data['slots'])) {
                            foreach ($data['slots'] as $key => $slot) {
                                if ( isset($slot['day'])) {
                                    $day_index = $slot['day'];
                                    unset($slot['day']);

                                    $slots[$day_index][] = $slot;
                                }
                            }

                            $data['slots'] = $slots;
                            $booking = $data;
                        }
                    } else {
                        $booking = $data;
                    }
                }
                break;

            default:
                $booking = $data;
                break;
        }

        return $booking;
    }

    /**
     *to manage the request data for Cart
     *
     * @param object $product
     * @param array $data
     * @return array
    */
    public function manageInputForCart($product, $data)
    {
        switch ($product->type) {
            case 'configurable':
                //Case: In case of configurable product added
                if ( isset($data['super_attribute']) && $data['super_attribute']) {
                    $super_attribute = [];
                    foreach ($data['super_attribute'] as $key => $attribute) {
                        if ( isset($attribute['attribute_id']) && isset($attribute['attribute_option_id'])) {
                            $super_attribute[$attribute['attribute_id']] = $attribute['attribute_option_id'];
                        }
                    }
                    $data['super_attribute'] = $super_attribute;
                }
                break;
            case 'grouped':
                //Case: In case of grouped product added
                if ( isset($data['qty']) && $data['qty']) {
                    $grouped_product = [];
                    foreach ($data['qty'] as $key => $product) {
                        if ( isset($product['product_id']) && isset($product['quantity'])) {
                            $grouped_product[$product['product_id']] = $product['quantity'];
                        }
                    }
                    $data['qty'] = $grouped_product;
                }
                break;
            case 'bundle':
                //Case: In case of bundled product added
                if ( isset($data['bundle_options']) && $data['bundle_options']) {
                    $bundleOptions = Arr::collapse($data['bundle_options']);
                    $data['bundle_options'] = $bundleOptions;

                    $option = [];
                    foreach ($data['bundle_options']['bundle_option_id'] as $key => $value) {
                        $option[$key+1] = [$key => $value];
                    }
                    $data['bundle_options'] = $option;
                }
                break;
            case 'booking':
                //Case: In case of booking product added
                if ( isset($data['booking']) && $data['booking']) {
                    $booking = $product->booking_product;

                    if ( isset($booking->type) && $booking->type) {
                        if ( $booking->type == 'default' || $booking->type == 'appointment' || $booking->type == 'table' ) {
                            if ( isset($data['booking']['slot']) && is_array($data['booking']['slot']) ) {
                                $data['booking']['slot'] = implode("-", $data['booking']['slot']);
                            }
                        } elseif ($booking->type == 'event' && (isset($data['booking']['qty']) && $data['booking']['qty']) ) {
                            $tickets = [];
                            $events = $data['booking']['qty'];
                            foreach ($events as $key => $ticket) {
                                if ( isset($ticket['ticket_id']) && isset($ticket['quantity']) ) {
                                    $tickets[$ticket['ticket_id']] = $ticket['quantity'];
                                }
                            }
                            $data['booking']['qty'] = $tickets;
                        }
                    }
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
     * @param mixed $collection
     * @param array $data
     * @param string $field
     * @return void
    */
    public function saveImageByURL($collection, $data = [], $field = 'image_url')
    {
        $getImgMime = null;
        $base64Validate = $pathValidate = false;
        $image_name = basename($data[$field]);
        
        if ($data['upload_type'] == 'base64') {
            $getImgMime = mime_content_type($data[$field]);
            
            $extension = explode("/", $getImgMime)[1];
        
            $image_name = $field . '_avatar.' . $extension;
            
            $base64Validate =  ($getImgMime && in_array($getImgMime, $this->allowedImageMimeTypes));
        } else {
            $pathValidate = $this->validatePath($data[$field], 'image');
        }
        
        if ($base64Validate || $pathValidate) {
            $keyIndex = explode("_", $field);

            if (! isset($keyIndex[0])) {
                return false;
            }
            
            if ($collection->{$keyIndex[0]}) {
                Storage::delete($collection->{$keyIndex[0]});
            }

            $collection->{$keyIndex[0]} = null;
            $collection->save();
        
            $path = $data['save_path'] . '/';

            $contents = file_get_contents($data[$field]);
            
            Storage::put($path . $image_name, $contents);
            
            $collection->{$keyIndex[0]} = $path . $image_name;
            $collection->save();
        }
    }
}
