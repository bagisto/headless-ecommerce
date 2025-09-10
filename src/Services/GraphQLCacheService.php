<?php

namespace Webkul\GraphQLAPI\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GraphQLCacheService
{
    /**
     * Cache TTL in seconds (24 hours)
     */
    public const CACHE_TTL = 60 * 60 * 24 * 30;

    /**
     * Cache key patterns mapping entity types to their related cache keys
     */
    protected static array $cacheKeyPatterns = [
        'channel' => [
            'getDefaultChannel',
            'homeCategories',
        ],

        'theme' => [
            'themeCustomization',
        ],

        'category' => [
            'homeCategories',
            'themeCustomization',
        ],

        'product' => [
            'allProducts',
            'compareProduct',
            'compareProducts',
            'themeCustomization',
            'wishlist',
            'wishlists',
            'getFilterAttribute',
        ],

        'attribute' => [
            'getFilterAttribute',
        ],

        'core-config-data' => [
            'learnMoreAndCustomize',
            'gdprRequest',
            'gdprRequests',
        ],

        'compare' => [
            'compareProduct',
            'compareProducts',
        ],

        'customer' => [
            'accountInfo',
        ],

        'address' => [
            'address',
            'addresses',
            'checkoutAddresses',
        ],

        'wishlist' => [
            'wishlist',
            'wishlists',
        ],

        'gdpr-request' => [
            'gdprRequest',
            'gdprRequests',
        ],

        'review' => [
            'reviewDetail',
            'reviewsList',
        ],

        'cart' => [
            'cartDetail',
            'cartItems',
        ],

        'order' => [
            'orderDetail',
            'ordersList',
            'viewInvoice',
            'viewInvoices',
            'viewRefund',
            'viewRefunds',
            'viewShipment',
            'viewShipments',
        ],
    ];

    /**
     * Queries that require entity ID in cache key
     */
    protected static array $cacheWithId = [
        'getDefaultChannel',
        'getFilterAttribute',
    ];

    /**
     * Queries that require customer ID in cache key
     */
    protected static array $cacheWithCustomerId = [
        'accountInfo',
        'address',
        'addresses',
        'cartDetail',
        'cartItems',
        'checkoutAddresses',
        'compareProduct',
        'compareProducts',
        'gdprRequest',
        'gdprRequests',
        'orderDetail',
        'ordersList',
        'reviewDetail',
        'reviewsList',
        'viewInvoice',
        'viewInvoices',
        'viewRefund',
        'viewRefunds',
        'viewShipment',
        'viewShipments',
        'wishlist',
        'wishlists',
    ];

    /**
     * Queries to skip from caching
     */
    protected static array $skipQueries = [
        'cartDetail',
        'cartItems',
        'downloadableLinkPurchase',
        'downloadableLinkPurchases',
        'shippingMethods',
        'paymentMethods',
        'checkoutAddresses',
    ];

    /**
     * Queries to skip for guest users
     */
    protected static array $skipForGuest = [
        'cartDetail',
        'cartItems',
        'checkoutAddresses',
    ];

    /**
     * Generate cache key for a GraphQL query
     */
    public static function generateCacheKey(
        $query,
        string $queryName,
        array $variables = [],
        array $headers = [],
        ?int $customerId = null
    ): string {
        $queryCacheKey = "query_cache_{$queryName}";

        if (
            in_array($queryName, self::$cacheWithCustomerId)
            && $customerId
        ) {
            $queryCacheKey = "{$queryCacheKey}_{$customerId}";
        }

        $cacheKey = "{$queryCacheKey}-".md5(json_encode([
            'query'     => $query,
            'headers'   => $headers,
            'variables' => $variables,
        ]));

        return $cacheKey;
    }

    /**
     * Generate tracking cache key for query management
     */
    public static function generateTrackingKey(string $queryName, ?int $entityId = null): string
    {
        $trackingKey = "query_cache_{$queryName}";

        if (
            in_array($queryName, self::$cacheWithId)
            && $entityId
        ) {
            $trackingKey = "{$trackingKey}_{$entityId}";
        }

        return $trackingKey;
    }

    /**
     * Check if query should be cached
     */
    public static function shouldCache(string $queryName, bool $isAuthenticated = false): bool
    {
        if (in_array($queryName, self::$skipQueries)) {
            return false;
        }

        if (
            in_array($queryName, self::$skipForGuest)
            && ! $isAuthenticated
        ) {
            return false;
        }

        return true;
    }

    /**
     * Get cache key patterns for a specific entity type
     */
    public static function getCurrentCustomerId(): ?int
    {
        return Auth::guard('api')->check() ? Auth::guard('api')->id() : null;
    }

    /**
     * Get cache key patterns for entity type
     */
    public static function getCacheKeyPatterns(string $entityType): array
    {
        return self::$cacheKeyPatterns[$entityType] ?? [];
    }

    /**
     * Get queries that require customer ID
     */
    public static function getCacheWithCustomerId(): array
    {
        return self::$cacheWithCustomerId;
    }

    /**
     * Get queries that require entity ID
     */
    public static function getCacheWithId(): array
    {
        return self::$cacheWithId;
    }

    /**
     * Log cache operation
     */
    public static function logCacheOperation(
        string $operation,
        string $key,
        ?string $context = null
    ): void {
        $message = "Cache {$operation}: {$key}";

        if ($context) {
            $message .= " | Context: {$context}";
        }

        Log::channel('graphql-cache')->info($message);
    }
}
