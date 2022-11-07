<?php

namespace Webkul\GraphQLAPI\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Webkul\GraphQLAPI\Models\PushNotification::class,
        \Webkul\GraphQLAPI\Models\PushNotificationTranslation::class,
    ];
}