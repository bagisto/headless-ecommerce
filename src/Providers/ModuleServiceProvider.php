<?php

namespace Webkul\GraphQLAPI\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    /**
     * The models of the GraphQL API module.
     *
     * @var array
     */
    protected $models = [
        \Webkul\GraphQLAPI\Models\PushNotification::class,
        \Webkul\GraphQLAPI\Models\PushNotificationTranslation::class,
    ];
}
