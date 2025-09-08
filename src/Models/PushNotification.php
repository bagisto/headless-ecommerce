<?php

namespace Webkul\GraphQLAPI\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
    public function imageUrl(): Attribute
    {
        return new Attribute(
            get: fn () => $this->image ? Storage::url($this->image) : null
        );
    }

    /**
     * Get the translations of the product.
     */
    public function translations()
    {
        return $this->hasMany(PushNotificationTranslation::class);
    }
}
