<?php

namespace SMSkin\IdentityService\Modules\Jwt\Controllers;

use SMSkin\IdentityService\Modules\Jwt\Models\JwtContext;
use SMSkin\IdentityService\Modules\Jwt\Requests\DecodeTokenRequest;
use MiladRahimi\Jwt\Exceptions\InvalidSignatureException;
use MiladRahimi\Jwt\Exceptions\InvalidTokenException;
use MiladRahimi\Jwt\Exceptions\JsonDecodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use MiladRahimi\Jwt\Exceptions\ValidationException;

class CInvalidateRefreshToken extends CInvalidateAccessToken
{
    /**
     * @return JwtContext
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     * @throws JsonDecodingException
     * @throws SigningException
     * @throws ValidationException
     */
    protected function decodeToken(): JwtContext
    {
        return app(CDecodeRefreshToken::class, [
            'request' => (new DecodeTokenRequest())
                ->setToken($this->request->token)
        ])->execute()->getResult();
    }
}
