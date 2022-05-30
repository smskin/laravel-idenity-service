<?php

namespace SMSkin\IdentityService\Modules\Auth\Requests;

use SMSkin\IdentityService\Modules\Core\Rules\PhoneRule;
use SMSkin\IdentityService\Modules\Core\BaseRequest;

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
