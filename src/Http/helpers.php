<?php

use Webkul\GraphQLAPI\BagistoGraphql;

if (! function_exists('bagisto_graphql')) {
    function bagisto_graphql()
    {
        return app()->make(BagistoGraphql::class);
    }
}
