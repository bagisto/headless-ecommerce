<?php

namespace Webkul\GraphQLAPI\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Webkul\GraphQLAPI\Services\GraphQLCacheService;

/**
 * Middleware to serve cached GraphQL responses
 */
class GraphQLCacheMiddleware
{
    /**
     * Handle an incoming request
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (! $this->shouldProcessRequest($request)) {
            return $next($request);
        }

        $query = $request->input('query');

        $queryName = $this->extractQueryName($query);

        if (! $queryName) {
            return $next($request);
        }

        $cachedResponse = $this->getCachedResponse($request, $queryName);

        if ($cachedResponse) {
            return $cachedResponse;
        }

        return $next($request);
    }

    /**
     * Check if request should be processed for caching
     */
    protected function shouldProcessRequest(Request $request): bool
    {
        return $request->is('graphql')
            && $request->isMethod('POST')
            && $request->input('query')
            && Str::startsWith(ltrim($request->input('query')), 'query');
    }

    /**
     * Extract query name from GraphQL query
     */
    protected function extractQueryName(string $query): ?string
    {
        if (preg_match('/query\s+(\w+)/', $query, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Get cached response if available
     */
    protected function getCachedResponse(Request $request, string $queryName): ?JsonResponse
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

        if (! Cache::has($cacheKey)) {
            return null;
        }

        $record = Cache::get($cacheKey);

        GraphQLCacheService::logCacheOperation('hit', $cacheKey, $queryName);

        return response()->json($record);
    }
}
