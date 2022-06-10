<?php

namespace SMSkin\IdentityService\Traits;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityServiceClient\Enums\ScopeGroups;
use function config;

trait ClassFromConfig
{
    public static function getUserModelClass(): string
    {
        return config('identity-service.classes.models.user');
    }

    /**
     * @return User
     */
    public static function getUserModel(): Model
    {
        return app(self::getUserModelClass());
    }

    public static function getSystemChangeScope(): string
    {
        return config('identity-service.modules.auth.scopes.system_change_scope');
    }

    public static function getScopeGroupsEnum(): ScopeGroups
    {
        return app(config('identity-service.classes.enums.scope_groups'));
    }

    public static function getUserPolicyClass(): string
    {
        return config('identity-service.classes.policies.user');
    }

    public static function getScopePolicyClass(): string
    {
        return config('identity-service.classes.policies.scope');
    }

    public static function getScopeGroupPolicyClass(): string
    {
        return config('identity-service.classes.policies.scope_group');
    }
}