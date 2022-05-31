<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests;

use SMSkin\IdentityService\Models\UserPhoneCredential;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;

class ExistCredentialRequest extends BaseRequest
{
    public UserPhoneCredential $credential;

    public function rules(): array
    {
        return [
            'credential' => [
                'required',
                new ExistsEloquentModelRule(UserPhoneCredential::class)
            ]
        ];
    }

    /**
     * @param UserPhoneCredential $credential
     * @return ExistCredentialRequest
     */
    public function setCredential(UserPhoneCredential $credential): ExistCredentialRequest
    {
        $this->credential = $credential;
        return $this;
    }
}
