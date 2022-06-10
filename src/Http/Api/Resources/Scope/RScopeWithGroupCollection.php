<?php

namespace SMSkin\IdentityService\Http\Api\Resources\Scope;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RScopeWithGroupCollection extends ResourceCollection
{
    public $collects = RScopeWithGroup::class;
}