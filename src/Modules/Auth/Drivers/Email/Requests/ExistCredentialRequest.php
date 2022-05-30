<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests;

use SMSkin\IdentityService\Models\UserEmailCredential;
use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\Core\Rules\ExistsEloquentModelRule;

class ExistCredentialRequest extends BaseRequest
{
    public UserEmailCredential $credential;

    public function rules(): array
    {
        return [
            'credential' => [
                'required',
                new ExistsEloquentModelRule(UserEmailCredential::class)
            ]
        ];
    }

    /**
     * @param UserEmailCredential $credential
     * @return ExistCredentialRequest
     */
    public function setCredential(UserEmailCredential $credential): ExistCredentialRequest
    {
        $this->credential = $credential;
        return $this;
    }
}
