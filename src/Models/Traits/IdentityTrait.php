<?php

namespace SMSkin\IdentityService\Models\Traits;

use SMSkin\IdentityServiceClient\Models\Traits\IdentityTrait as BaseTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use SMSkin\IdentityService\Models\Scope;
use SMSkin\IdentityService\Models\ScopeGroup;
use SMSkin\IdentityService\Models\UserEmailCredential;
use SMSkin\IdentityService\Models\UserOAuthCredential;
use SMSkin\IdentityService\Models\UserPhoneCredential;

trait IdentityTrait
{
    use BaseTrait;

    public function getName(): string
    {
        return $this->name;
    }

    public function getIdentityUuid(): string
    {
        return $this->identity_uuid;
    }

    /**
     * @return Collection<Scope>
     */
    public function getScopes(): Collection
    {
        $scopes = collect();
        $scopeGroups = $this->scopeGroups()->with(['scopes'])->get();
        $scopeGroups->each(function (ScopeGroup $group) use ($scopes) {
            $group->scopes()->get()->each(function (Scope $scope) use ($scopes) {
                $scopes->push($scope);
            });
        });

        $this->scopes()->get()->each(function (Scope $scope) use ($scopes) {
            if (!$scopes->contains(function (Scope $item) use ($scope) {
                return $item->id === $scope->id;
            })) {
                $scopes->push($scope);
            }
        });
        return $scopes;
    }

    public function emailCredentials(): HasMany
    {
        return $this->hasMany(UserEmailCredential::class);
    }

    public function phoneCredentials(): HasMany
    {
        return $this->hasMany(UserPhoneCredential::class);
    }

    public function oauthCredentials(): HasMany
    {
        return $this->hasMany(UserOAuthCredential::class);
    }

    public function scopeGroups(): BelongsToMany
    {
        return $this->belongsToMany(ScopeGroup::class, 'pivot_scope_group_user', 'user_id', 'group_id');
    }

    public function scopes(): BelongsToMany
    {
        return $this->belongsToMany(Scope::class, 'pivot_scope_user', 'user_id', 'scope_id');
    }
}