<?php

namespace Webkul\GraphQLAPI\Listeners;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Nuwave\Lighthouse\Events\EndExecution;
use Illuminate\Support\Facades\Cache;

class SetCacheQuery
{
    /**
     * Handle the event.
     */
    public function handle(EndExecution $event): void
    {
        if ($request = Request::instance()->input('query')) {
            if (Str::startsWith(ltrim($request), 'query')) {
                $cacheKey = 'cache_query_' . md5(json_encode($request));
                
                Cache::put($cacheKey, $event->result);
                Log::info("Cache set for query: {$cacheKey}");
            } elseif (! Str::startsWith(ltrim($request), 'mutation')) {
                Log::info("It's neither a query nor a mutation");
            }
        }
    }
}
