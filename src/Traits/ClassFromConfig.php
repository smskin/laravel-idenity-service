<?php

namespace SMSkin\IdentityService\Traits;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityServiceClient\Enums\ScopeGroups;
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

    public function getSystemChangeScope(): string
    {
        return config('identity-service.modules.auth.scopes.system_change_scope');
    }

    public function getScopeGroupsEnum(): ScopeGroups
    {
        return app(config('identity-service.classes.enums.scope_groups'));
    }
}