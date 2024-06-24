<?php

namespace Webkul\GraphQLAPI\Models;

use Illuminate\Support\Facades\Storage;
use Webkul\Core\Eloquent\TranslatableModel;
use Webkul\GraphQLAPI\Contracts\PushNotification as PushNotificationContract;

class PushNotification extends TranslatableModel implements PushNotificationContract
{
    protected $guarded = ['_token'];

    /**
     * Translated attributes.
     *
     * @var array
     */
    public $translatedAttributes = [
        'title',
        'content',
    ];

    /**
     * Fillables.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'product_category_id',
        'status',
    ];

    /**
     * Eager loading.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * Get image url for the Banner image.
     */
    public function image_url()
    {
        if (! $this->image) {
            return;
        }

        return Storage::url($this->image);
    }

    /**
     * Get image url for the Banner image.
     */
    public function getImageUrlAttribute()
    {
        return $this->image_url();
    }
}
