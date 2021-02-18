<?php

namespace Webkul\GraphQLAPI\Models\Core;

use Webkul\Core\Contracts\CountryTranslation as CountryTranslationContract;
use Webkul\Core\Models\CountryStateTranslation as BaseModel;

class CountryTranslation extends BaseModel implements CountryTranslationContract
{
    public $timestamps = false;

    protected $fillable = ['name'];
}