<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests;

use SMSkin\IdentityService\Models\UserPhoneVerification;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;

class ExistVerificationRequest extends BaseRequest
{
    public UserPhoneVerification $verification;

    public function rules(): array
    {
        return [
            'verification' => [
                'required',
                new ExistsEloquentModelRule(UserPhoneVerification::class)
            ]
        ];
    }

    /**
     * @param UserPhoneVerification $verification
     * @return ExistVerificationRequest
     */
    public function setVerification(UserPhoneVerification $verification): ExistVerificationRequest
    {
        $this->verification = $verification;
        return $this;
    }
}
