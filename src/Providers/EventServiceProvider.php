<?php

namespace Webkul\GraphQLAPI\Providers;

use Nuwave\Lighthouse\Events\EndExecution;
use Webkul\GraphQLAPI\Listeners\SetCacheQuery;
use Webkul\GraphQLAPI\Listeners\InjectGdprData;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        EndExecution::class => [
            InjectGdprData::class,
            SetCacheQuery::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
    }
}