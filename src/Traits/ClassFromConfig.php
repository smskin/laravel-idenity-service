<?php

namespace SMSkin\IdentityService\Traits;

use BackedEnum;
use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use function config;

trait ClassFromConfig
{
    public function getUserModelClass(): string
    {
        return config('identity-service.classes.models.user');
    }

    /**
     * @return User
     */
    public function getUserModel(): Model
    {
        return app($this->getUserModelClass());
    }

    public function getSystemChangeScope(): BackedEnum
    {
        return config('identity-service.modules.auth.scopes.system-change-scope');
    }
}