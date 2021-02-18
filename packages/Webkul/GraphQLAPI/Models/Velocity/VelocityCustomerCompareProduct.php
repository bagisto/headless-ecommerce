<?php

namespace Webkul\GraphQlAPI\Models\Velocity;

use Webkul\Velocity\Models\VelocityCustomerCompareProduct as BaseModel;
use Webkul\Product\Models\ProductFlatProxy;
use Webkul\Customer\Models\CustomerProxy;

class VelocityCustomerCompareProduct extends BaseModel
{
    protected $guarded = [];

    public function product_flat()
    {
        return $this->belongsTo(ProductFlatProxy::modelClass(), 'product_flat_id');
    }

    public function customer()
    {
        return $this->belongsTo(CustomerProxy::modelClass(), 'customer_id');
    }
}