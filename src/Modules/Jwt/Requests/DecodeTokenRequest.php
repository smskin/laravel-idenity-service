<?php

namespace SMSkin\IdentityService\Modules\Jwt\Requests;

use SMSkin\LaravelSupport\BaseRequest;

class DecodeTokenRequest extends BaseRequest
{
    public string $token;

    public function rules(): array
    {
        return [
            'token' => 'required'
        ];
    }

    /**
     * @param string $token
     * @return DecodeTokenRequest
     */
    public function setToken(string $token): DecodeTokenRequest
    {
        $this->token = $token;
        return $this;
    }
}
