<?php

namespace SMSkin\IdentityService\Modules\Jwt\Controllers;

use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\Jwt\Models\JwtContext;
use SMSkin\IdentityService\Modules\Jwt\Requests\DecodeTokenRequest;
use SMSkin\IdentityService\Modules\Jwt\Requests\InvalidateAccessTokenRequest;
use SMSkin\IdentityService\Modules\Jwt\Tools\InvalidatedTokenStorage;
use MiladRahimi\Jwt\Exceptions\InvalidSignatureException;
use MiladRahimi\Jwt\Exceptions\InvalidTokenException;
use MiladRahimi\Jwt\Exceptions\JsonDecodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use MiladRahimi\Jwt\Exceptions\ValidationException;

class CInvalidateAccessToken extends BaseController
{
    protected InvalidateAccessTokenRequest|BaseRequest|null $request;

    protected ?string $requestClass = InvalidateAccessTokenRequest::class;

    /**
     * @return static
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     * @throws JsonDecodingException
     * @throws SigningException
     * @throws ValidationException
     */
    public function execute(): static
    {
        $jwt = $this->request->jwt ?? $this->decodeToken();

        app(InvalidatedTokenStorage::class)->putJti($jwt->jti);
        return $this;
    }

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
        return app(CDecodeAccessToken::class, [
            'request' => (new DecodeTokenRequest())
                ->setToken($this->request->token)
        ])->execute()->getResult();
    }
}
