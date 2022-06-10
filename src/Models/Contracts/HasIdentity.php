<?php

namespace SMSkin\IdentityService\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use SMSkin\IdentityServiceClient\Models\Contracts\HasIdentity as BaseContract;
use SMSkin\IdentityService\Models\Scope;

interface HasIdentity extends BaseContract
{
    public function getName(): string;

    public function getIdentityUuid(): string;

    /**
     * @return Collection<Scope>
     */
    public function getScopes(): Collection;

    public function emailCredentials(): HasMany;

    public function phoneCredentials(): HasMany;

    public function oauthCredentials(): HasMany;

    public function scopeGroups(): BelongsToMany;

    public function scopes(): BelongsToMany;
}