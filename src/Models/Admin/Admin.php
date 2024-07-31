<?php

namespace Webkul\GraphQLAPI\Models\Admin;

use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Webkul\User\Models\Admin as BaseModel;

class Admin extends BaseModel implements JWTSubject
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
