<?php

namespace SMSkin\IdentityService\Modules\Jwt\Requests;

use SMSkin\LaravelSupport\BaseRequest;

class GenerateAccessTokenRequest extends BaseRequest
{
    public string $subject;
    public array $scopes;

    public function rules(): array
    {
        return [
            'subject' => [
                'required'
            ],
            'scopes' => [
                'required',
                'array'
            ]
        ];
    }

    /**
     * @param string $subject
     * @return GenerateAccessTokenRequest
     */
    public function setSubject(string $subject): GenerateAccessTokenRequest
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @param array $scopes
     * @return GenerateAccessTokenRequest
     */
    public function setScopes(array $scopes): GenerateAccessTokenRequest
    {
        $this->scopes = $scopes;
        return $this;
    }
}
