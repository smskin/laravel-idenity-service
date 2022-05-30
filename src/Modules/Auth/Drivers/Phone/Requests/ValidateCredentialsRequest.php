<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests;

use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\Core\Rules\PhoneRule;

class ValidateCredentialsRequest extends BaseRequest
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
     * @return ValidateCredentialsRequest
     */
    public function setPhone(string $phone): ValidateCredentialsRequest
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @param string $code
     * @return ValidateCredentialsRequest
     */
    public function setCode(string $code): ValidateCredentialsRequest
    {
        $this->code = $code;
        return $this;
    }
}
