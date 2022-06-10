<?php

namespace SMSkin\IdentityService\Modules\Jwt;

use SMSkin\IdentityService\Modules\Auth\Exceptions\InvalidScopes;
use SMSkin\LaravelSupport\BaseModule;
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

        return (new CGenerateAccessToken($request))->execute()->getResult();
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

        return (new CGenerateAccessTokenByUser($request))->execute()->getResult();
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

        return (new CDecodeAccessToken($request))->execute()->getResult();
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

        return (new CDecodeRefreshToken($request))->execute()->getResult();
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

        return (new CValidateAccessToken($request))->execute()->getResult();
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

        (new CValidateRefreshToken($request))->execute();
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

        return (new CRefreshAccessToken($request))->execute()->getResult();
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

        (new CInvalidateAccessToken($request))->execute();
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

        (new CInvalidateRefreshToken($request))->execute();
    }
}
