<?php

namespace Webkul\GraphQLAPI\Facades;

use Illuminate\Support\Facades\Facade;

class BagistoGraphql extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bagisto_graphql';
    }
}
