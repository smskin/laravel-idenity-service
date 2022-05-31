<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests;

use SMSkin\IdentityService\Models\UserEmailCredential;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;

class UpdateCredentialPasswordRequest extends BaseRequest
{
    public UserEmailCredential $credential;
    public string $password;

    public function rules(): array
    {
        return [
            'credential' => [
                'required',
                new ExistsEloquentModelRule(UserEmailCredential::class)
            ],
            'password' => [
                'required'
            ]
        ];
    }

    /**
     * @param UserEmailCredential $credential
     * @return UpdateCredentialPasswordRequest
     */
    public function setCredential(UserEmailCredential $credential): UpdateCredentialPasswordRequest
    {
        $this->credential = $credential;
        return $this;
    }

    /**
     * @param string $password
     * @return UpdateCredentialPasswordRequest
     */
    public function setPassword(string $password): UpdateCredentialPasswordRequest
    {
        $this->password = $password;
        return $this;
    }
}
