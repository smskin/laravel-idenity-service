<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests;

use SMSkin\IdentityService\Models\UserEmailCredential;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;

class CreateVerificationContextRequest extends BaseRequest
{
    public UserEmailCredential $credential;
    public string $code;

    public function rules(): array
    {
        return [
            'credential' => [
                'required',
                new ExistsEloquentModelRule(UserEmailCredential::class)
            ],
            'code' => [
                'required'
            ]
        ];
    }

    /**
     * @param string $code
     * @return CreateVerificationContextRequest
     */
    public function setCode(string $code): CreateVerificationContextRequest
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @param UserEmailCredential $credential
     * @return CreateVerificationContextRequest
     */
    public function setCredential(UserEmailCredential $credential): CreateVerificationContextRequest
    {
        $this->credential = $credential;
        return $this;
    }
}
