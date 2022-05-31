<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests;

use SMSkin\IdentityService\Models\UserEmailVerification;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;

class ExistVerificationRequest extends BaseRequest
{
    public UserEmailVerification $verification;

    public function rules(): array
    {
        return [
            'verification' => [
                'required',
                new ExistsEloquentModelRule(UserEmailVerification::class)
            ]
        ];
    }

    /**
     * @param UserEmailVerification $verification
     * @return ExistVerificationRequest
     */
    public function setVerification(UserEmailVerification $verification): ExistVerificationRequest
    {
        $this->verification = $verification;
        return $this;
    }
}
