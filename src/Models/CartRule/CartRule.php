<?php

namespace Webkul\GraphQLAPI\Models\CartRule;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Webkul\CartRule\Models\CartRule as BaseCartRule;
use Webkul\CartRule\Models\CartRuleCouponProxy;

class CartRule extends BaseCartRule
{
    /**
     * Get the coupons that owns the cart rule.
     */
    public function cart_rule_coupons(): HasMany
    {
        return $this->hasMany(CartRuleCouponProxy::modelClass());
    }
}
