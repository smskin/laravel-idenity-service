<?php

namespace SMSkin\IdentityService\Modules\Jwt;

use SMSkin\IdentityService\Modules\Auth\Exceptions\InvalidScopes;
use SMSkin\IdentityService\Modules\Core\BaseModule;
use SMSkin\IdentityService\Modules\Jwt\Controllers\CDecodeAccessToken;
use SMSkin\IdentityService\Modules\Jwt\Controllers\CDecodeRefreshToken;
use SMSkin\IdentityService\Modules\Jwt\Controllers\CGenerateAccessToken;
use SMSkin\IdentityService\Modules\Jwt\Controllers\CGenerateAccessTokenByUser;
use SMSkin\IdentityService\Modules\Jwt\Controllers\CInvalidateRefreshToken;
use SMSkin\IdentityService\Modules\Jwt\Controllers\CRefreshAccessToken;
use SMSkin\IdentityService\Modules\Jwt\Controllers\CInvalidateAccessToken;
use SMSkin\IdentityService\Modules\Jwt\Controllers\CValidateAccessToken;
use SMSkin\IdentityService\Modules\Jwt\Controllers\CValidateRefreshToken;
use SMSkin\IdentityService\Modules\Jwt\Models\Jwt;
use SMSkin\IdentityService\Modules\Jwt\Requests\DecodeTokenRequest;
use SMSkin\IdentityService\Modules\Jwt\Requests\GenerateAccessTokenByUserRequest;
use SMSkin\IdentityService\Modules\Jwt\Requests\GenerateAccessTokenRequest;
use SMSkin\IdentityService\Modules\Jwt\Requests\RefreshAccessTokenRequest;
use SMSkin\IdentityService\Modules\Jwt\Requests\InvalidateAccessTokenRequest;
use SMSkin\IdentityService\Modules\Jwt\Requests\ValidateTokenRequest;
use Illuminate\Validation\ValidationException;
use MiladRahimi\Jwt\Exceptions\InvalidSignatureException;
use MiladRahimi\Jwt\Exceptions\InvalidTokenException;
use MiladRahimi\Jwt\Exceptions\JsonDecodingException;
use MiladRahimi\Jwt\Exceptions\JsonEncodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use MiladRahimi\Jwt\Exceptions\ValidationException as JwtValidationException;

class JwtModule extends BaseModule
{
    /**
     * @param GenerateAccessTokenRequest $request
     * @return Jwt
     * @throws JsonEncodingException
     * @throws SigningException
     * @throws ValidationException
     */
    public function generateAccessToken(GenerateAccessTokenRequest $request): Jwt
    {
        $request->validate();

        return app(CGenerateAccessToken::class, [
            'request' => $request
        ])->execute()->getResult();
    }

    /**
     * @param GenerateAccessTokenByUserRequest $request
     * @return Jwt
     * @throws JsonEncodingException
     * @throws SigningException
     * @throws ValidationException
     */
    public function generateAccessTokenByUser(GenerateAccessTokenByUserRequest $request): Jwt
    {
        $request->validate();

        return app(CGenerateAccessTokenByUser::class, [
            'request' => $request
        ])->execute()->getResult();
    }

    /**
     * @param DecodeTokenRequest $request
     * @return Models\JwtContext
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     * @throws JsonDecodingException
     * @throws JwtValidationException
     * @throws SigningException
     * @throws ValidationException
     */
    public function decodeAccessToken(DecodeTokenRequest $request): Models\JwtContext
    {
        $request->validate();

        return app(CDecodeAccessToken::class, [
            'request' => $request
        ])->execute()->getResult();
    }

    /**
     * @param DecodeTokenRequest $request
     * @return Models\JwtContext
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     * @throws JsonDecodingException
     * @throws JwtValidationException
     * @throws SigningException
     * @throws ValidationException
     */
    public function decodeRefreshToken(DecodeTokenRequest $request): Models\JwtContext
    {
        $request->validate();

        return app(CDecodeRefreshToken::class, [
            'request' => $request
        ])->execute()->getResult();
    }

    /**
     * @param ValidateTokenRequest $request
     * @return void
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     * @throws JsonDecodingException
     * @throws JwtValidationException
     * @throws SigningException
     * @throws ValidationException
     */
    public function validateAccessToken(ValidateTokenRequest $request)
    {
        $request->validate();

        app(CValidateAccessToken::class, [
            'request' => $request
        ])->execute();
    }

    /**
     * @param ValidateTokenRequest $request
     * @return void
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     * @throws JsonDecodingException
     * @throws JwtValidationException
     * @throws SigningException
     * @throws ValidationException
     */
    public function validateRefreshToken(ValidateTokenRequest $request)
    {
        $request->validate();

        app(CValidateRefreshToken::class, [
            'request' => $request
        ])->execute();
    }

    /**
     * @param RefreshAccessTokenRequest $request
     * @return Jwt
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     * @throws JsonDecodingException
     * @throws JsonEncodingException
     * @throws JwtValidationException
     * @throws SigningException
     * @throws ValidationException
     * @throws InvalidScopes
     */
    public function refreshAccessToken(RefreshAccessTokenRequest $request): Jwt
    {
        $request->validate();

        return app(CRefreshAccessToken::class, [
            'request' => $request
        ])->execute()->getResult();
    }

    /**
     * @param InvalidateAccessTokenRequest $request
     * @return void
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     * @throws JsonDecodingException
     * @throws JwtValidationException
     * @throws SigningException
     * @throws ValidationException
     */
    public function invalidateAccessToken(InvalidateAccessTokenRequest $request): void
    {
        $request->validate();

        app(CInvalidateAccessToken::class, [
            'request' => $request
        ])->execute();
    }

    /**
     * @param InvalidateAccessTokenRequest $request
     * @return void
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     * @throws JsonDecodingException
     * @throws JwtValidationException
     * @throws SigningException
     * @throws ValidationException
     */
    public function invalidateRefreshToken(InvalidateAccessTokenRequest $request): void
    {
        $request->validate();

        app(CInvalidateRefreshToken::class, [
            'request' => $request
        ])->execute();
    }
}
