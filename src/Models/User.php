<?php

namespace SMSkin\IdentityService\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SMSkin\IdentityService\Models\Contracts\HasIdentity;
use SMSkin\IdentityService\Models\Traits\IdentityTrait;

class User extends Authenticatable implements HasIdentity, AuthenticatableContract
{
    use IdentityTrait;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'identity_uuid'
    ];
}
