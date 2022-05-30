<?php

namespace SMSkin\IdentityService\Modules\Jwt\Tools;

use SMSkin\IdentityService\Modules\Jwt\Models\JwtContext;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Validation\ValidationException;
use MiladRahimi\Jwt\Exceptions\InvalidSignatureException;
use MiladRahimi\Jwt\Exceptions\InvalidTokenException;
use MiladRahimi\Jwt\Exceptions\JsonDecodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use MiladRahimi\Jwt\Exceptions\ValidationException as JwtValidationException;

interface IJwtGuard extends Guard
{
    public function getJwt(): ?JwtContext;

    /**
     * @return void
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     * @throws JsonDecodingException
     * @throws JwtValidationException
     * @throws SigningException
     * @throws ValidationException
     */
    public function logout(): void;
}
