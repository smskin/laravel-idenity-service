<?php

namespace SMSkin\IdentityService\Modules\Jwt\Requests;

use SMSkin\IdentityService\Modules\Core\BaseRequest;

class ValidateTokenRequest extends BaseRequest
{
    public string $token;

    public function rules(): array
    {
        return [
            'token' => [
                'required'
            ]
        ];
    }

    /**
     * @param string $token
     * @return ValidateTokenRequest
     */
    public function setToken(string $token): ValidateTokenRequest
    {
        $this->token = $token;
        return $this;
    }
}
