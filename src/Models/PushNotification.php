<?php

namespace Webkul\GraphQLAPI\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Webkul\GraphQLAPI\Contracts\PushNotification as PushNotificationContract;

class PushNotification extends Model implements PushNotificationContract
{
    /**
     * The attributes that are mass assignable.
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
    public function getImageUrlAttribute()
    {
        if (! $this->image) {
            return;
        }

        return Storage::url($this->image);
    }

    /**
     * Get the translations of the product.
     */
    public function translations()
    {
        return $this->hasMany(PushNotificationTranslation::class);
    }
}
