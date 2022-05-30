<?php

namespace SMSkin\IdentityService\Modules\Auth\Exceptions;

class InvalidScopes extends AuthException
{
    public array $scopes;

    public function __construct(array $scopes)
    {
        $this->scopes = $scopes;
        parent::__construct();
    }
}
