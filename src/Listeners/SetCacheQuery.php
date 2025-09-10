<?php

namespace Webkul\GraphQLAPI\Listeners;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Nuwave\Lighthouse\Events\EndExecution;
use Webkul\GraphQLAPI\Services\GraphQLCacheService;

/**
 * Listener to cache GraphQL query results
 */
class SetCacheQuery
{
    /**
     * Handle the GraphQL execution end event
     */
    public function handle(EndExecution $event): void
    {
        if (isset($event->result->errors)) {
            return;
        }

        $request = request();

        $query = $request->input('query');

        if (! $this->shouldProcessQuery($query)) {
            return;
        }

        $queryName = $this->extractQueryName($query);

        if (
            ! $queryName
            || ! GraphQLCacheService::shouldCache($queryName, auth()->guard('api')->check())
        ) {
            return;
        }

        $this->cacheQueryResult($event, $request, $queryName);
    }

    /**
     * Check if query should be processed for caching
     */
    protected function shouldProcessQuery(?string $query): bool
    {
        return $query && Str::startsWith(ltrim($query), 'query');
    }

    /**
     * Extract query name from GraphQL query string
     */
    protected function extractQueryName(string $query): ?string
    {
        if (preg_match('/query\s+(\w+)/', $query, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Cache the query result
     */
    protected function cacheQueryResult(EndExecution $event, $request, string $queryName): void
    {
        $query = $request->input('query', []);

        $variables = $request->input('variables', []);

        $headers = $request->headers->all();

        $customerId = GraphQLCacheService::getCurrentCustomerId();

        $relevantHeaders = collect($headers)->only(['x-currency', 'x-locale'])->toArray();

        $cacheKey = GraphQLCacheService::generateCacheKey(
            $query,
            $queryName,
            $variables,
            $relevantHeaders,
            $customerId
        );

        $trackingKey = GraphQLCacheService::generateTrackingKey(
            $queryName,
            $this->extractEntityId($event, $queryName)
        );

        Cache::put($cacheKey, $event->result, GraphQLCacheService::CACHE_TTL);

        GraphQLCacheService::logCacheOperation('set', $cacheKey, $queryName);

        $existingKeys = Cache::get($trackingKey, []);

        $existingKeys[] = $cacheKey;

        Cache::put($trackingKey, array_unique($existingKeys), GraphQLCacheService::CACHE_TTL);

        GraphQLCacheService::logCacheOperation('tracked', $trackingKey, "Added {$cacheKey}");
    }

    /**
     * Extract entity ID from query result if needed
     */
    protected function extractEntityId(EndExecution $event, string $queryName): ?int
    {
        if (! in_array($queryName, GraphQLCacheService::getCacheWithId())) {
            return null;
        }

        return data_get($event->result->data, "{$queryName}.id");
    }
}
