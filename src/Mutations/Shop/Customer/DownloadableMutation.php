<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Exception;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Shop\Http\Controllers\Controller;
use Webkul\Sales\Repositories\DownloadableLinkPurchasedRepository;
use Webkul\GraphQLAPI\Validators\Customer\CustomException;

class DownloadableMutation extends Controller
{
    /**
     * Contains current guard
     *
     * @var array
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Sales\Repositories\DownloadableLinkPurchasedRepository  $downloadableLinkPurchasedRepository
     * @return void
     */
    public function __construct(protected DownloadableLinkPurchasedRepository $downloadableLinkPurchasedRepository)
    {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);
        
        $this->middleware('auth:' . $this->guard);
    }

    /**
     * Returns customer's purchased downloadable links
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadLinks($rootValue, array $args , GraphQLContext $context)
    {
        if (! bagisto_graphql()->guard($this->guard)->check() ) {
            throw new Exception(trans('bagisto_graphql::app.shop.customer.no-login-customer'));
        }

        try {
            $params = isset($args['input']) ? $args['input'] : (isset($args['id']) ? $args : []);

            $currentPage = isset($params['page']) ? $params['page'] : 1;
            
            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });

            $downloads = app(DownloadableLinkPurchasedRepository::class)->scopeQuery(function ($query) use ($params) {
                $channel_id = isset($params['channel_id']) ?: (core()->getCurrentChannel()->id ?: core()->getDefaultChannel()->id);
                $customer = bagisto_graphql()->guard($this->guard)->user();
                    
                $qb = $query->distinct()
                    ->addSelect('downloadable_link_purchased.*')
                    ->leftJoin('orders', 'downloadable_link_purchased.order_id', '=', 'orders.id')
                    ->leftJoin('order_items', 'downloadable_link_purchased.order_item_id', '=', 'order_items.id')
                    ->where('orders.channel_id', $channel_id)
                    ->where('downloadable_link_purchased.customer_id', $customer->id);

                if (isset($params['id']) && $params['id']) {
                    $qb->where('downloadable_link_purchased.id', $params['id']);
                }
                
                if (isset($params['order_id']) && $params['order_id']) {
                    $qb->where('downloadable_link_purchased.order_id', $params['order_id']);
                }
                
                if (isset($params['order_item_id']) && $params['order_item_id']) {
                    $qb->where('downloadable_link_purchased.order_item_id', $params['order_item_id']);
                }

                if (isset($params['product_name']) && $params['product_name']) {
                    $qb->where('downloadable_link_purchased.product_name', 'like', '%' . urldecode($params['product_name']) . '%');
                }

                if (isset($params['link_name']) && $params['link_name']) {
                    $qb->where('downloadable_link_purchased.name', 'like', '%' . urldecode($params['link_name']) . '%');
                }
                
                if (isset($params['status']) && $params['status']) {
                    $qb->where('downloadable_link_purchased.status', $params['status']);
                }
                
                if (isset($params['download_bought']) && $params['download_bought']) {
                    $qb->where('downloadable_link_purchased.download_bought', $params['download_bought']);
                }
                
                if (isset($params['download_used']) && $params['download_used']) {
                    $qb->where('downloadable_link_purchased.download_used', $params['download_used']);
                }
                
                if (isset($params['status']) && $params['status']) {
                    $qb->where('downloadable_link_purchased.status', $params['status']);
                }

                return $qb;
            });

            if (isset($args['id'])) {
                $downloads = $downloads->first();
            } else {
                $downloads = $downloads->paginate( isset($params['limit']) ? $params['limit'] : 10);
            }
            
            if ( ($downloads && isset($downloads->first()->id)) || isset($downloads->id) ) {
                return $downloads;
            } else {
                throw new CustomException(
                    trans('bagisto_graphql::app.shop.response.not-found', ['name' => 'downloadable purchase link']),
                    'Resource not found'
                );
            }
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                'Error: Downloadable Purchase Link'
            );
        }
    }

    /**
     * Download the for the specified resource.
     *
     * @param  null  $rootValue
     * @param  array{}  $args
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context
     * @return \Illuminate\Http\Response
     */
    public function download($rootValue, array $args, GraphQLContext $context)
    {
        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new CustomException(
                trans('bagisto_graphql::app.admin.response.invalid-header'),
                'Invalid request header parameter.'
            );
        }

        if (! bagisto_graphql()->guard($this->guard)->check() ) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.customer.no-login-customer'),
                'No Login Customer Found.'
            );
        }

        $customer = bagisto_graphql()->guard($this->guard)->user();

        try {
            $downloadableLinkPurchased = $this->downloadableLinkPurchasedRepository->findOneByField([
                'id'          => $args['id'],
                'customer_id' => $customer->id,
            ]);

            if (
                ! $downloadableLinkPurchased 
                || $downloadableLinkPurchased->status == 'pending'
            ) {
                throw new CustomException(
                    trans('bagisto_graphql::app.shop.customer.not-authorized'),
                    'You are not authorized to perform this action.'
                );
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
                throw new CustomException(
                    trans('shop::app.customer.account.downloadable_products.payment-error'),
                    'Downloadable product payment error.'
                );
            }

            if (
                $downloadableLinkPurchased->download_bought
                && ($downloadableLinkPurchased->download_bought - $totalUsedAndCancelQty) <= 0
            ) {
                throw new CustomException(
                    trans('shop::app.customer.account.downloadable_products.download-error'),
                    'Downloadable link product download error.'
                );
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
                
                $base64_str = 'data:image/' . $type . ';base64,' . $base64_code;

                return [
                    'status' => true,
                    'string' => $base64_str,
                    'download' => $this->downloadableLinkPurchasedRepository->findOrFail($args['id'])
                ];
            }
            
            $privateDisk = Storage::disk('private');

            if (! $privateDisk->exists($downloadableLinkPurchased->file)) {
                throw new CustomException(
                    trans('shop::app.customer.account.downloadable_products.download-error'),
                    'Downloadable link product download error.'
                );
            }

            $pathToFile = $privateDisk->path($downloadableLinkPurchased->file);

            $type = pathinfo($pathToFile, PATHINFO_EXTENSION);

            $base64_str = 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents($pathToFile));

            return [
                'status' => true,
                'string' => $base64_str,
                'download' => $this->downloadableLinkPurchasedRepository->findOrFail($args['id'])
            ];
        } catch (\Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                'Failed: Downloadable purchased link.'
            );
        }
    }
}