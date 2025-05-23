<?php

namespace Webkul\GraphQLAPI\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

/**
 * Cache configuration and utility service for GraphQL operations
 */
class GraphQLCacheService
{
    /**
     * Cache TTL in seconds (24 hours)
     */
    public const CACHE_TTL = 60*60*24*30;

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
            'themeCustomization',
            'compareProducts',
            'compareProduct',
            'wishlists',
            'wishlist',
        ],
        'attribute' => [
            'getFilterAttribute',
        ],
        'core-config-data' => [
            'learnMoreAndCustomize',
        ],
        'compare-product' => [
            'compareProducts',
            'compareProduct',
        ],
        'customer' => [
            'accountInfo',
        ],
        'address' => [
            'addresses',
            'address',
            'checkoutAddresses',
        ],
        'wishlist' => [
            'wishlists',
            'wishlist',
        ],
        'gdpr-request' => [
            'gdprRequests',
            'gdprRequest',
        ],
        'review' => [
            'reviewsList',
            'reviewDetail'
        ],
        'cart' => [
            'cartDetail',
            'cartItems',
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
        'compareProducts',
        'compareProduct',
        'accountInfo',
        'addresses',
        'address',
        'wishlists',
        'wishlist',
        'gdprRequests',
        'gdprRequest',
        'reviewsList',
        'reviewDetail',
        'cartDetail',
        'cartItems',
        'checkoutAddresses',
    ];

    /**
     * Queries to skip from caching
     */
    protected static array $skipQueries = [
        'compareProducts',
        'compareProduct',
        'wishlists',
        'wishlist',
        'downloadableLinkPurchases',
        'downloadableLinkPurchase',
        'reviewsList',
        'reviewDetail',
        'cartDetail',
        'cartItems',
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
    public static function generateCacheKey(string $queryName, array $variables = [], array $headers = [], ?int $customerId = null): string
    {
        $queryCacheKey = "query_cache_{$queryName}";
        
        if (
            in_array($queryName, self::$cacheWithCustomerId)
            && $customerId
        ) {
            $queryCacheKey = "{$queryCacheKey}_{$customerId}";
        }
        
        $cacheKey = "{$queryCacheKey}-" . md5(json_encode([
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
    public static function logCacheOperation(string $operation, string $key, ?string $context = null): void
    {
        $message = "Cache {$operation}: {$key}";
        if ($context) {
            $message .= " | Context: {$context}";
        }
        
        Log::channel('graphql-cache')->info($message);
    }

    /**
     * Get GDPR data for response
     */
    public static function getGdprData(): array
    {
        return [
            'cookieTitle'           => core()->getConfigData('general.gdpr.cookie.static_block_identifier'),
            'cookieDescription'     => core()->getConfigData('general.gdpr.cookie.description'),
            'privacyPolicyUrlKey'   => 'page/privacy-policy',
            'privacyPolicyText'     => trans('shop::app.components.layouts.cookie.index.privacy-policy'),
            'cookieAccept'          => trans('shop::app.components.layouts.cookie.index.accept'),
            'cookieReject'          => trans('shop::app.components.layouts.cookie.index.reject'),
            'learnMoreAndCustomize' => 'learnMoreAndCustomize',
        ];
    }

    /**
     * Check if GDPR should be applied
     */
    public static function shouldApplyGdpr(array $headers): bool
    {
        return ! Auth::guard('admin-api')->check()
            && core()->getConfigData('general.gdpr.settings.enabled')
            && core()->getConfigData('general.gdpr.cookie.enabled')
            && (
                empty($headers['is-cookie-exist'][0])
                || $headers['is-cookie-exist'][0] === 'false'
            );
    }
}