<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests;

use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\LaravelSupport\Rules\PhoneRule;

class CreateVerificationContextRequest extends BaseRequest
{
    public string $phone;
    public string $code;

    public function rules(): array
    {
        return [
            'phone' => [
                'required',
                new PhoneRule()
            ],
            'code' => [
                'required'
            ]
        ];
    }

    /**
     * @param string $phone
     * @return CreateVerificationContextRequest
     */
    public function setPhone(string $phone): CreateVerificationContextRequest
    {
        $this->phone = $phone;
        return $this;
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
}
