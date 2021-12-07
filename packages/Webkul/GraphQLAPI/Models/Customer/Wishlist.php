<?php

namespace Webkul\GraphQLAPI\Models\Customer;

use Webkul\Product\Models\ProductProxy;
use Webkul\Core\Models\ChannelProxy;
use Webkul\Customer\Models\CustomerProxy;
use Webkul\Customer\Models\Wishlist as BaseModel;

class Wishlist extends BaseModel
{
    /**
     * The Product that belong to the wishlist.
     */
    public function product()
    {
        return $this->hasOne(ProductProxy::modelClass(), 'id', 'product_id');
    }

    /**
     * The Channel that belong to the wishlist.
     */
    public function channel()
    {
        return $this->hasOne(ChannelProxy::modelClass(), 'id', 'channel_id');
    }

    /**
     * The Customer that belong to the wishlist.
     */
    public function customer()
    {
        return $this->belongsTo(CustomerProxy::modelClass(), 'customer_id');
    }

}
