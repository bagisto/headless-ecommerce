<?php

namespace Webkul\GraphQLAPI\Listeners;

use Illuminate\Support\Facades\Cache;
use Webkul\Customer\Models\CompareItem;
use Webkul\Customer\Models\CustomerAddress;
use Webkul\GraphQLAPI\Services\GraphQLCacheService;
use Webkul\Product\Models\ProductReview;

/**
 * Listener to clear GraphQL cache when entities are modified
 */
class ClearCache
{
    /**
     * Clear cache keys for a specific entity type
     */
    public function clearCacheForEntity(string $entityType, $record = null, ?int $customerId = null): void
    {
        $cachePatterns = GraphQLCacheService::getCacheKeyPatterns($entityType);

        if (empty($cachePatterns)) {
            return;
        }

        foreach ($cachePatterns as $queryName) {
            $this->clearQueryCache($queryName, $record, $customerId, $entityType);
        }
    }

    /**
     * Clear cache for a specific query
     */
    protected function clearQueryCache(string $queryName, $record = null, ?int $customerId = null, string $context = ''): void
    {
        $trackingKey = GraphQLCacheService::generateTrackingKey($queryName, $record?->id);

        if (! Cache::has($trackingKey)) {
            GraphQLCacheService::logCacheOperation('miss', $trackingKey, "No tracking key found for {$context}");

            return;
        }

        $cachedKeys = Cache::get($trackingKey, []);

        $clearedCount = 0;

        foreach ($cachedKeys as $cacheKey) {
            if ($this->shouldClearCacheKey($queryName, $cacheKey, $customerId)) {
                Cache::forget($cacheKey);

                $clearedCount++;

                GraphQLCacheService::logCacheOperation('cleared', $cacheKey, $context);
            }
        }

        if ($clearedCount > 0) {
            // Clear the tracking key as well
            Cache::forget($trackingKey);

            GraphQLCacheService::logCacheOperation('cleared', $trackingKey, "Tracking key for {$context}");
        }
    }

    /**
     * Determine if a cache key should be cleared based on customer ID
     */
    protected function shouldClearCacheKey(string $queryName, string $cacheKey, ?int $customerId): bool
    {
        if (
            ! in_array($queryName, GraphQLCacheService::getCacheWithCustomerId())
            || ! $customerId
        ) {
            return true;
        }

        $expectedPrefix = "query_cache_{$queryName}_{$customerId}";

        return str_starts_with(explode('-', $cacheKey)[0], $expectedPrefix);
    }

    // Event handlers

    public function afterChannelUpdate($channel): void
    {
        $this->clearCacheForEntity('channel', $channel);
    }

    public function afterConfigurationSave(): void
    {
        $this->clearCacheForEntity('core-config-data');

        $this->clearCacheForEntity('product');
    }

    public function afterThemeCustomizationCreateOrUpdateOrDelete($themeCustomization): void
    {
        $this->clearCacheForEntity('theme');
    }

    public function afterCategoryCreateOrUpdate($category): void
    {
        $this->clearCacheForEntity('category');

        $this->clearCacheForEntity('attribute', $category);
    }

    public function afterProductUpdateOrDelete($product): void
    {
        $this->clearCacheForEntity('product');
    }

    public function afterAttributeCreate($attribute): void
    {
        $this->clearCacheForEntity('attribute');
    }

    public function afterCustomerUpdate($customer): void
    {
        $this->clearCacheForEntity('customer', null, $customer->id);
    }

    public function afterAddressCreateOrUpdate($address): void
    {
        $this->clearCacheForEntity('address', null, $address->customer_id);
    }

    public function beforeAddressDelete($id): void
    {
        $address = CustomerAddress::find($id);

        $this->clearCacheForEntity('address', null, $address->customer_id);
    }

    public function afterGdprRequestCreateOrUpdate($gdprRequest): void
    {
        $this->clearCacheForEntity('gdpr-request', null, $gdprRequest->customer_id);
    }

    public function afterReviewCreateOrUpdate($review): void
    {
        $this->clearCacheForEntity('review', null, $review->customer_id);
    }

    public function beforeReviewDelete($id): void
    {
        $review = ProductReview::find($id);

        $this->clearCacheForEntity('review', null, $review->customer_id);
    }

    public function afterCartCreateOrUpdate($cart): void
    {
        if ($cart->is_guest) {
            return;
        }

        $this->clearCacheForEntity('cart', null, $cart->customer_id);
    }

    public function afterOrderSave($order): void
    {
        if ($order->is_guest) {
            return;
        }

        $this->clearCacheForEntity('order', null, $order->customer_id);
    }

    public function afterInvoiceSave($invoice): void
    {
        $this->clearCacheForEntity('order', null, $invoice->order->customer_id);
    }

    public function afterRefundSave($refund): void
    {
        $this->clearCacheForEntity('order', null, $refund->order->customer_id);
    }

    public function afterShipmentSave($shipment): void
    {
        $this->clearCacheForEntity('order', null, $shipment->order->customer_id);
    }

    public function beforeWishlistDelete($id): void
    {
        $wishlist = \Webkul\Customer\Models\Wishlist::find($id);

        $this->clearCacheForEntity('wishlist', null, $wishlist?->customer_id);
    }

    public function afterWishlistCreateOrUpdate($wishlist): void
    {
        $this->clearCacheForEntity('wishlist', null, $wishlist->customer_id);
    }

    public function afterWishlistDeleteAll(): void
    {
        $this->clearCacheForEntity('wishlist');
    }

    public function beforeCompareDelete($id): void
    {
        $compare = CompareItem::find($id);

        $this->clearCacheForEntity('compare', null, $compare?->customer_id);
    }

    public function afterCompareCreateOrUpdate($compare): void
    {
        $this->clearCacheForEntity('compare', null, $compare?->customer_id);
    }

    public function afterCompareDeleteAll(): void
    {
        $this->clearCacheForEntity('compare');
    }
}
