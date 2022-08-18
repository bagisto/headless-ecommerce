<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\Paginator;
use Webkul\Shop\Http\Controllers\Controller;
use Webkul\Sales\Repositories\DownloadableLinkPurchasedRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

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
     * @return void
     */
    public function __construct()
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

                if ( isset($params['id']) && $params['id']) {
                    $qb->where('downloadable_link_purchased.id', $params['id']);
                }
                
                if ( isset($params['order_id']) && $params['order_id']) {
                    $qb->where('downloadable_link_purchased.order_id', $params['order_id']);
                }
                
                if ( isset($params['order_item_id']) && $params['order_item_id']) {
                    $qb->where('downloadable_link_purchased.order_item_id', $params['order_item_id']);
                }

                if ( isset($params['product_name']) && $params['product_name']) {
                    $qb->where('downloadable_link_purchased.product_name', 'like', '%' . urldecode($params['product_name']) . '%');
                }

                if ( isset($params['link_name']) && $params['link_name']) {
                    $qb->where('downloadable_link_purchased.name', 'like', '%' . urldecode($params['link_name']) . '%');
                }
                
                if ( isset($params['status']) && $params['status']) {
                    $qb->where('downloadable_link_purchased.status', $params['status']);
                }
                
                if ( isset($params['download_bought']) && $params['download_bought']) {
                    $qb->where('downloadable_link_purchased.download_bought', $params['download_bought']);
                }
                
                if ( isset($params['download_used']) && $params['download_used']) {
                    $qb->where('downloadable_link_purchased.download_used', $params['download_used']);
                }
                
                if ( isset($params['status']) && $params['status']) {
                    $qb->where('downloadable_link_purchased.status', $params['status']);
                }

                return $qb;
            });

            if ( isset($args['id'])) {
                $downloads = $downloads->first();
            } else {
                $downloads = $downloads->paginate( isset($params['limit']) ? $params['limit'] : 10);
            }
            
            if ( ($downloads && isset($downloads->first()->id)) || isset($downloads->id) ) {
                return $downloads;
            } else {
                throw new Exception(trans('bagisto_graphql::app.shop.response.not-found', ['name'   => 'Downloadable Purchase Link']));
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}