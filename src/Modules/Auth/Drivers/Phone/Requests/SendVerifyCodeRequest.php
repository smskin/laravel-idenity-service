<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests;

use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\LaravelSupport\Rules\PhoneRule;

class SendVerifyCodeRequest extends BaseRequest
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
     * @return SendVerifyCodeRequest
     */
    public function setPhone(string $phone): SendVerifyCodeRequest
    {
        $this->phone = $phone;
        return $this;
    }
}
