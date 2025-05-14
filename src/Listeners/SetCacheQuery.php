<?php

namespace Webkul\GraphQLAPI\Listeners;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Nuwave\Lighthouse\Events\EndExecution;
use Illuminate\Support\Facades\Cache;

class SetCacheQuery
{
    /**
     * Handle the event.
     */
    public function handle(EndExecution $event): void
    {
        return;
        
        // Get the request
        $request = request(); // Or inject via constructor if preferred
        
        // Get the GraphQL query from the request
        $query = $request->input('query');

        // Extract input: [ {...} ] from the query using regex
        preg_match('/input\s*:\s*\[(.*?)\]/s', $query, $matches);

        $inputRaw = $matches[1] ?? null;

        $args = [];

        if ($inputRaw) {
            preg_match_all('/key\s*:\s*"([^"]+)"\s*,\s*value\s*:\s*"([^"]+)"/', $inputRaw, $pairs, PREG_SET_ORDER);

            foreach ($pairs as $pair) {
                $key = $pair[1];
                $value = $pair[2];
                $args[$key] = $value;
            }
        }

        // dd($args);
        
        if (
            $query
            && Str::startsWith(ltrim($query), 'query')
        ) {
            $headers = $request->headers->all();

            $cacheKey = 'cache_query_' . md5(json_encode($query));
            
            Cache::put($cacheKey, $event->result);
            Log::info("Cache set for query: {$cacheKey}");
        }
    }
}
