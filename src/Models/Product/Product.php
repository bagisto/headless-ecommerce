<?php

namespace Webkul\GraphQLAPI\Models\Product;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\BookingProduct\Models\BookingProductProxy;
use Webkul\Product\Models\Product as BaseProduct;

class Product extends BaseProduct
{
    /**
     * The bookings that belong to the product.
     */
    public function booking_product(): BelongsTo
    {
        return $this->belongsTo(BookingProductProxy::modelClass(), 'id', 'product_id');
    }
}
