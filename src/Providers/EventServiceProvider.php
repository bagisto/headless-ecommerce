<?php

namespace Webkul\GraphQLAPI\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Nuwave\Lighthouse\Events\EndExecution;
use Webkul\GraphQLAPI\Listeners\ClearCache;
use Webkul\GraphQLAPI\Listeners\SetCacheQuery;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // GraphQL execution events
        EndExecution::class => [
            SetCacheQuery::class,
        ],

        // Core entity events
        'core.channel.update.after' => [
            ClearCache::class.'@afterChannelUpdate',
        ],
        'core.configuration.save.after' => [
            ClearCache::class.'@afterConfigurationSave',
        ],

        // Theme events
        'theme_customization.create.after' => [
            ClearCache::class.'@afterThemeCustomizationCreateOrUpdate',
        ],
        'theme_customization.update.after' => [
            ClearCache::class.'@afterThemeCustomizationCreateOrUpdate',
        ],

        // Catalog events
        'catalog.category.create.after' => [
            ClearCache::class.'@afterCategoryCreateOrUpdate',
        ],
        'catalog.category.update.after' => [
            ClearCache::class.'@afterCategoryCreateOrUpdate',
        ],
        'catalog.product.update.after' => [
            ClearCache::class.'@afterProductUpdate',
        ],
        'catalog.attribute.create.after' => [
            ClearCache::class.'@afterAttributeCreate',
        ],

        // Customer events
        'customer.update.after' => [
            ClearCache::class.'@afterCustomerUpdate',
        ],
        'customer.addresses.create.after' => [
            ClearCache::class.'@afterAddressCreateOrUpdate',
        ],
        'customer.addresses.update.after' => [
            ClearCache::class.'@afterAddressCreateOrUpdate',
        ],
        'customer.addresses.delete.before' => [
            ClearCache::class.'@beforeAddressDelete',
        ],
        'customer.review.update.after' => [
            ClearCache::class.'@afterReviewCreateOrUpdate',
        ],
        'customer.review.create.after' => [
            ClearCache::class.'@afterReviewCreateOrUpdate',
        ],
        'customer.review.delete.before' => [
            ClearCache::class.'@beforeReviewDelete',
        ],
        'customer.wishlist.delete.before' => [
            ClearCache::class.'@beforeWishlistDelete',
        ],
        'customer.wishlist.move-to-cart.after' => [
            ClearCache::class.'@beforeWishlistDelete',
        ],
        'customer.wishlist.create.after' => [
            ClearCache::class.'@afterWishlistCreateOrUpdate',
        ],
        'customer.wishlist.delete-all.after' => [
            ClearCache::class.'@afterWishlistDeleteAll',
        ],

        'customer.compare.delete.before' => [
            ClearCache::class.'@beforeCompareDelete',
        ],
        'customer.compare.create.after' => [
            ClearCache::class.'@afterCompareCreateOrUpdate',
        ],
        'customer.compare.delete-all.after' => [
            ClearCache::class.'@afterCompareDeleteAll',
        ],

        // GDPR events
        'customer.account.gdpr-request.create.after' => [
            ClearCache::class.'@afterGdprRequestCreateOrUpdate',
        ],
        'customer.account.gdpr-request.update.after' => [
            ClearCache::class.'@afterGdprRequestCreateOrUpdate',
        ],

        // Order events
        'checkout.order.save.after' => [
            ClearCache::class.'@afterOrderSave',
        ],
        'sales.invoice.save.after' => [
            ClearCache::class.'@afterInvoiceSave',
        ],
        'sales.refund.save.after' => [
            ClearCache::class.'@afterRefundSave',
        ],
        'sales.shipment.save.after' => [
            ClearCache::class.'@afterShipmentSave',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot() {}
}
