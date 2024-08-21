<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Illuminate\Pagination\Paginator;
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
     * Returns customer's purchased downloadable links
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadLinks($rootValue, array $args, GraphQLContext $context)
    {
        $customer = bagisto_graphql()->authorize();

        $currentPage = $args['page'] ?? 1;

        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        $downloads = app(DownloadableLinkPurchasedRepository::class)->scopeQuery(function ($query) use ($args) {
            $channel_id = isset($args['channel_id']) ?: (core()->getCurrentChannel()->id ?: core()->getDefaultChannel()->id);

            return $query->distinct()
                ->addSelect('downloadable_link_purchased.*')
                ->leftJoin('orders', 'downloadable_link_purchased.order_id', '=', 'orders.id')
                ->leftJoin('order_items', 'downloadable_link_purchased.order_item_id', '=', 'order_items.id')
                ->where('orders.channel_id', $channel_id)
                ->where('downloadable_link_purchased.customer_id', auth()->user()->id)
                ->when(! empty($args['id']), function ($qb) use ($args) {
                    $qb->where('downloadable_link_purchased.id', $args['id']);
                })
                ->when(! empty($args['order_id']), function ($qb) use ($args) {
                    $qb->where('downloadable_link_purchased.order_id', $args['order_id']);
                })
                ->when(! empty($args['order_item_id']), function ($qb) use ($args) {
                    $qb->where('downloadable_link_purchased.order_item_id', $args['order_item_id']);
                })
                ->when(! empty($args['product_name']), function ($qb) use ($args) {
                    $qb->where('downloadable_link_purchased.product_name', 'like', '%'.urldecode($args['product_name']).'%');
                })
                ->when(! empty($args['link_name']), function ($qb) use ($args) {
                    $qb->where('downloadable_link_purchased.name', 'like', '%'.urldecode($args['link_name']).'%');
                })
                ->when(! empty($args['status']), function ($qb) use ($args) {
                    $qb->where('downloadable_link_purchased.status', $args['status']);
                })
                ->when(! empty($args['download_bought']), function ($qb) use ($args) {
                    $qb->where('downloadable_link_purchased.download_bought', $args['download_bought']);
                })
                ->when(! empty($args['download_used']), function ($qb) use ($args) {
                    $qb->where('downloadable_link_purchased.download_used', $args['download_used']);
                })
                ->when(! empty($args['status']), function ($qb) use ($args) {
                    $qb->where('downloadable_link_purchased.status', $args['status']);
                });
        });

        if (isset($args['id'])) {
            $downloads = $downloads->first();
        } else {
            $downloads = $downloads->paginate($args['limit'] ?? 10);
        }

        if (
            (
                $downloads
                && isset($downloads->first()->id)
            ) || isset($downloads->id)
        ) {
            return $downloads;
        } else {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.downloadable-products.not-found'));
        }
    }

    /**
     * Download the for the specified resource.
     */
    public function download($rootValue, array $args, GraphQLContext $context)
    {
        $customer = bagisto_graphql()->authorize();

        try {
            $downloadableLinkPurchased = $this->downloadableLinkPurchasedRepository->findOneByField([
                'id'          => $args['id'],
                'customer_id' => auth()->user()->id,
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
