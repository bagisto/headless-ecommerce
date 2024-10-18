<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Common;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Product\Repositories\ProductDownloadableLinkRepository;
use Webkul\Product\Repositories\ProductDownloadableSampleRepository;
use Webkul\Product\Repositories\ProductRepository;

class DownloadableProductMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected ProductRepository $productRepository,
        protected ProductDownloadableSampleRepository $productDownloadableSampleRepository,
        protected ProductDownloadableLinkRepository $productDownloadableLinkRepository
    ) {}

    /**
     * Download the for the specified resource.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function downloadSample(mixed $rootValue, array $args)
    {
        $fileContents = null;

        if ($args['type'] === 'link') {
            $productDownloadableLink = $this->productDownloadableLinkRepository->find($args['id']);

            if (! $productDownloadableLink) {
                throw new CustomException(trans('bagisto_graphql::app.shop.downloadable-products.download-sample.link-not-found'));
            }

            if ($productDownloadableLink->sample_type === 'file') {
                $privateDisk = Storage::disk('private');
                $sampleFile = $productDownloadableLink->sample_file;

                if ($privateDisk->exists($sampleFile)) {
                    $fileContents = $privateDisk->get($sampleFile);
                }
            } else {
                $fileContents = @file_get_contents($productDownloadableLink->sample_url);
            }
        } else {
            $productDownloadableSample = $this->productDownloadableSampleRepository->find($args['id']);

            if (! $productDownloadableSample) {
                throw new CustomException(trans('bagisto_graphql::app.shop.downloadable-products.download-sample.sample-not-found'));
            }

            $product = $this->productRepository->find($productDownloadableSample->product_id);

            if (! $product) {
                throw new CustomException(trans('bagisto_graphql::app.shop.downloadable-products.download-sample.sample-not-found'));
            }

            if (! $product->visible_individually) {
                return [
                    'success' => false,
                    'string'  => null,
                ];
            }

            if ($productDownloadableSample->type === 'file') {
                $fileContents = Storage::get($productDownloadableSample->file);
            } else {
                $fileContents = @file_get_contents($productDownloadableSample->url);
            }
        }

        if (
            $fileContents === false
            || $fileContents === null
        ) {
            return [
                'success' => false,
                'string'  => null,
            ];
        }

        return [
            'success' => true,
            'string'  => base64_encode($fileContents),
        ];
    }
}
