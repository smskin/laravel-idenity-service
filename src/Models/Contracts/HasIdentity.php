<?php

namespace SMSkin\IdentityService\Models\Contracts;

use Illuminate\Support\Collection;
use SMSkin\IdentityServiceClient\Models\Contracts\HasIdentity as BaseContract;
use SMSkin\IdentityService\Models\Scope;

interface HasIdentity extends BaseContract
{
    /**
     * @return Collection<Scope>
     */
    public function getScopes(): Collection;
}