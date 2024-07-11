<?php

namespace Webkul\GraphQLAPI\Repositories;

use Webkul\Core\Eloquent\Repository;
use Webkul\GraphQLAPI\Contracts\PushNotificationTranslation;

class NotificationTranslationRepository extends Repository
{
    /**
     * Specify model class name.
     *
     * @return mixed
     */
    public function model()
    {
        return PushNotificationTranslation::class;
    }
}
