<?php

namespace Webkul\GraphQLAPI\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\GraphQLAPI\Contracts\PushNotificationTranslation as PushNotificationTranslationContract;

class PushNotificationTranslation extends Model implements PushNotificationTranslationContract
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'locale',
        'channel',
        'push_notification_id',
    ];

    /**
     * Disable the timestamp.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the notification that owns the attribute value.
     */
    public function notification(): BelongsTo
    {
        return $this->belongsTo(PushNotificationProxy::modelClass());
    }
}
