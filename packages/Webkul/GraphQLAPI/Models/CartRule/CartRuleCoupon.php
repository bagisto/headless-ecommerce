<?php

namespace Webkul\GraphQLAPI\Models\CartRule;
use Webkul\CartRule\Models\CartRuleCouponUsageProxy;

use Webkul\CartRule\Models\CartRuleCoupon as BaseModel;

class CartRuleCoupon extends BaseModel
{
    
    /**
     * Get the cart rule that owns the cart rule coupon.
     */
    public function coupon_usage()
    {
        return $this->hasMany(CartRuleCouponUsageProxy::modelClass());
    }
}