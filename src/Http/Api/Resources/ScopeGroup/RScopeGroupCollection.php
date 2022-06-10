<?php

namespace SMSkin\IdentityService\Http\Api\Resources\ScopeGroup;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RScopeGroupCollection extends ResourceCollection
{
    public $collects = RScopeGroup::class;
}