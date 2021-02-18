<?php

namespace Webkul\GraphQLAPI\Models\BookingProduct;

use Webkul\BookingProduct\Models\BookingProduct as BaseModel;
use Webkul\Product\Models\ProductProxy;

class BookingProduct extends BaseModel
{
    protected $fillable = [
        'location',
        'show_location',
        'type',
        'qty',
        'available_every_week',
        'available_from',
        'available_to',
        'product_id',
    ];

    protected $with = ['default_slot', 'appointment_slot', 'event_tickets', 'rental_slot', 'table_slot'];

    protected $casts = [
        'available_from' => 'datetime',
        'available_to'   => 'datetime',
    ];

    /**
     * The Product belong to the product booking.
     */
    public function product()
    {
        return $this->belongsTo(ProductProxy::modelClass());
    }
}