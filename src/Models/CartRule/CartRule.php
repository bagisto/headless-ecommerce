<?php

namespace Webkul\GraphQLAPI\Models\CartRule;

use Webkul\CartRule\Models\CartRuleCouponProxy;
use Webkul\CartRule\Models\CartRule as BaseCartRule;

class CartRule extends BaseCartRule
{
    /**
     * Get the coupons that owns the cart rule.
     */
    public function cart_rule_coupons(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CartRuleCouponProxy::modelClass());
    }
}
