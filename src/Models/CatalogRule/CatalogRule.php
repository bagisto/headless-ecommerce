<?php

namespace Webkul\GraphQLAPI\Models\CatalogRule;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Webkul\CatalogRule\Models\CatalogRule as BaseModel;
use Webkul\CatalogRule\Models\CatalogRuleProductProxy;
use Webkul\CatalogRule\Models\CatalogRuleProductPriceProxy;

class CatalogRule extends BaseModel
{
    /**
     * Get the Catalog rule Product that owns the catalog rule.
     */
    public function catalog_rule_products(): HasMany
    {
        return $this->hasMany(CatalogRuleProductProxy::modelClass());
    }

    /**
     * Get the Catalog rule Product that owns the catalog rule.
     */
    public function catalog_rule_product_prices(): HasMany
    {
        return $this->hasMany(CatalogRuleProductPriceProxy::modelClass());
    }
}
