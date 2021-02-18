<?php

namespace Webkul\GraphQLAPI\Models\Core;

use Webkul\Core\Eloquent\TranslatableModel;
use Webkul\Core\Contracts\Country as CountryContract;
use Webkul\Core\Models\CountryStateProxy;

class Country extends TranslatableModel implements CountryContract
{
    public $timestamps = false;

    public $translatedAttributes = ['name'];

    protected $with = ['translations'];

    /**
     * Get the States.
     */
    public function states()
    {
        return $this->hasMany(CountryStateProxy::modelClass());
    }
}