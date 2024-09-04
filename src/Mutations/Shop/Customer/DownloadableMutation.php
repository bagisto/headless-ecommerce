<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Sales\Repositories\DownloadableLinkPurchasedRepository;
use Webkul\Shop\Http\Controllers\Controller;

class DownloadableMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected DownloadableLinkPurchasedRepository $downloadableLinkPurchasedRepository)
    {
        Auth::setDefaultDriver('api');
    }

    /**
     * Download the for the specified resource.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function download(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $customer = bagisto_graphql()->authorize();

        try {
            $downloadableLinkPurchased = $this->downloadableLinkPurchasedRepository->findOneByField([
                'id'          => $args['id'],
                'customer_id' => $customer->id,
            ]);

            if (
                ! $downloadableLinkPurchased
                || $downloadableLinkPurchased->status == 'pending'
            ) {
                throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.downloadable-products.not-auth'));
            }

            $totalInvoiceQty = 0;

            if (isset($downloadableLinkPurchased->order->invoices)) {
                foreach ($downloadableLinkPurchased->order->invoices as $invoice) {
                    $totalInvoiceQty = $totalInvoiceQty + $invoice->total_qty;
                }
            }

            $orderedQty = $downloadableLinkPurchased->order->total_qty_ordered;

            $totalInvoiceQty = $totalInvoiceQty * ($downloadableLinkPurchased->download_bought / $orderedQty);

            $totalUsedAndCancelQty = $downloadableLinkPurchased->download_used + $downloadableLinkPurchased->download_canceled;

            if (
                $downloadableLinkPurchased->download_used == $totalInvoiceQty
                || $downloadableLinkPurchased->download_used > $totalInvoiceQty
            ) {
                throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.downloadable-products.payment-error'));
            }

            if (
                $downloadableLinkPurchased->download_bought
                && ($downloadableLinkPurchased->download_bought - $totalUsedAndCancelQty) <= 0
            ) {
                throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.downloadable-products.download-error'));
            }

            $remainingDownloads = $downloadableLinkPurchased->download_bought - ($totalUsedAndCancelQty + 1);

            if ($downloadableLinkPurchased->download_bought) {
                $this->downloadableLinkPurchasedRepository->update([
                    'download_used' => $downloadableLinkPurchased->download_used + 1,
                    'status'        => $remainingDownloads <= 0 ? 'expired' : $downloadableLinkPurchased->status,
                ], $downloadableLinkPurchased->id);
            }

            if ($downloadableLinkPurchased->type == 'url') {
                $type = pathinfo($downloadableLinkPurchased->url, PATHINFO_EXTENSION);

                $base64_code = base64_encode(file_get_contents($downloadableLinkPurchased->url));

                $base64_str = 'data:image/'.$type.';base64,'.$base64_code;

                return [
                    'success'  => true,
                    'string'   => $base64_str,
                    'download' => $this->downloadableLinkPurchasedRepository->findOrFail($args['id']),
                ];
            }

            $privateDisk = Storage::disk('private');

            if (! $privateDisk->exists($downloadableLinkPurchased->file)) {
                throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.downloadable-products.download-error'));
            }

            $pathToFile = $privateDisk->path($downloadableLinkPurchased->file);

            $type = pathinfo($pathToFile, PATHINFO_EXTENSION);

            $base64_str = 'data:image/'.$type.';base64,'.base64_encode(file_get_contents($pathToFile));

            return [
                'success'  => true,
                'string'   => $base64_str,
                'download' => $this->downloadableLinkPurchasedRepository->findOrFail($args['id']),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
