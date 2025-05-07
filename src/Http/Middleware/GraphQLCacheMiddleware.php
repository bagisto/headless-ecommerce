<?php

namespace Webkul\GraphQLAPI\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GraphQLCacheMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('graphql') && $request->isMethod('POST')) {
            $query = $request->input('query');
            
            $cacheKey = 'cache_query_' . md5(json_encode($query));
            
            if (Cache::has($cacheKey)) {
                $result = response()->json(Cache::get($cacheKey));

                return response()->json($result->getData()->result);
            }

            // Store key to be used after response
            $request->attributes->set('graphql_cache_key', $cacheKey);
        }

        return $next($request);
    }
}
