<?php

namespace SMSkin\IdentityService\Modules\Auth\Requests;

use SMSkin\LaravelSupport\Rules\PhoneRule;
use SMSkin\LaravelSupport\BaseRequest;

class SendPhoneVerificationCodeRequest extends BaseRequest
{
    public string $phone;

    public function rules(): array
    {
        return [
            'phone' => [
                'required',
                new PhoneRule()
            ]
        ];
    }

    /**
     * @param string $phone
     * @return SendPhoneVerificationCodeRequest
     */
    public function setPhone(string $phone): SendPhoneVerificationCodeRequest
    {
        $this->phone = $phone;
        return $this;
    }
}
