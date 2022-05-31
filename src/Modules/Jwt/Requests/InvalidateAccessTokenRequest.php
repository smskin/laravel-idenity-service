<?php

namespace SMSkin\IdentityService\Modules\Jwt\Requests;

use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\LaravelSupport\Rules\InstanceOfRule;
use SMSkin\IdentityService\Modules\Jwt\Models\JwtContext;

class InvalidateAccessTokenRequest extends BaseRequest
{
    public string|null $token;
    public JwtContext|null $jwt = null;

    public function rules(): array
    {
        return [
            'token' => [
                'nullable',
                'required_without:jwt'
            ],
            'jwt' => [
                'nullable',
                'required_without:token',
                new InstanceOfRule(JwtContext::class)
            ]
        ];
    }

    /**
     * @param string $token
     * @return InvalidateAccessTokenRequest
     */
    public function setToken(string $token): InvalidateAccessTokenRequest
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @param JwtContext|null $jwt
     * @return InvalidateAccessTokenRequest
     */
    public function setJwt(?JwtContext $jwt): InvalidateAccessTokenRequest
    {
        $this->jwt = $jwt;
        return $this;
    }
}
