<?php

namespace Webkul\GraphQLAPI\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Webkul\Core\Models\CurrencyProxy;
use Webkul\Core\Models\CurrencyExchangeRate as BaseModel;

class CurrencyExchangeRate extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'target_currency',
        'rate',
    ];

    /**
     * Get the exchange rate associated with the currency.
     */
    public function currency()
    {
        return $this->belongsTo(CurrencyProxy::modelClass(), 'target_currency');
    }
}