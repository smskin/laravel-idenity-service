<?php

namespace SMSkin\IdentityService\Modules\Jwt\Controllers;

use SMSkin\IdentityService\Modules\Jwt\Enum\TokenType;
use SMSkin\IdentityService\Modules\Jwt\JwtValidationRules\NotBlockedTokenByJti;
use MiladRahimi\Jwt\Validator\DefaultValidator;
use MiladRahimi\Jwt\Validator\Rules\EqualsTo;
use MiladRahimi\Jwt\Validator\Rules\NewerThan;

class CValidateRefreshToken extends CValidateAccessToken
{
    protected function getValidator(): DefaultValidator
    {
        $validator = new DefaultValidator();
        $validator->addRule('exp', new NewerThan(now()->timestamp));
        $validator->addRule('type', new EqualsTo(TokenType::REFRESH_TOKEN->value));
        $validator->addRule('jti', new NotBlockedTokenByJti());
        return $validator;
    }
}
