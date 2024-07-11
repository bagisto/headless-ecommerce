<?php

namespace Webkul\GraphQLAPI\Models\Customer;

use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Webkul\Customer\Models\Customer as BaseModel;

class Customer extends BaseModel implements JWTSubject
{
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
