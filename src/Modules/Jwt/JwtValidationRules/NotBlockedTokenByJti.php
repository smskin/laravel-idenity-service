<?php

namespace SMSkin\IdentityService\Modules\Jwt\JwtValidationRules;

use SMSkin\IdentityService\Modules\Jwt\Tools\InvalidatedTokenStorage;
use MiladRahimi\Jwt\Exceptions\ValidationException;
use MiladRahimi\Jwt\Validator\Rule;

class NotBlockedTokenByJti implements Rule
{
    public function validate(string $name, $value)
    {
        $isBlocked = app(InvalidatedTokenStorage::class)->hasByJti($value);

        if ($isBlocked) {
            throw new ValidationException("The token is invalidated.");
        }
    }
}
