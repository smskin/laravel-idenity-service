<?php

namespace SMSkin\IdentityService\Http\Api\Resources\Scope;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RScopeCollection extends ResourceCollection
{
    public $collects = RScope::class;
}