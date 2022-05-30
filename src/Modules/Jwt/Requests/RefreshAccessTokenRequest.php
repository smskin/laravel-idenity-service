<?php

namespace SMSkin\IdentityService\Modules\Jwt\Requests;

use SMSkin\IdentityService\Modules\Core\BaseRequest;

class RefreshAccessTokenRequest extends BaseRequest
{
    public string $token;
    public ?array $scopes;

    public function rules(): array
    {
        return [
            'token' => [
                'required'
            ],
            'scopes' => [
                'nullable',
                'array'
            ]
        ];
    }

    /**
     * @param string $token
     * @return RefreshAccessTokenRequest
     */
    public function setToken(string $token): RefreshAccessTokenRequest
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @param array|null $scopes
     * @return RefreshAccessTokenRequest
     */
    public function setScopes(?array $scopes): RefreshAccessTokenRequest
    {
        $this->scopes = $scopes;
        return $this;
    }
}
