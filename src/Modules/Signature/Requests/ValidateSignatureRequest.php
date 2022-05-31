<?php

namespace SMSkin\IdentityService\Modules\Signature\Requests;

use SMSkin\LaravelSupport\BaseRequest;

class ValidateSignatureRequest extends BaseRequest
{
    public string $value;
    public string $salt;
    public string $signature;

    public function rules(): array
    {
        return [
            'value' => [
                'required'
            ],
            'salt' => [
                'required'
            ],
            'signature' => [
                'required'
            ]
        ];
    }

    /**
     * @param string $value
     * @return ValidateSignatureRequest
     */
    public function setValue(string $value): ValidateSignatureRequest
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param string $salt
     * @return ValidateSignatureRequest
     */
    public function setSalt(string $salt): ValidateSignatureRequest
    {
        $this->salt = $salt;
        return $this;
    }

    /**
     * @param string $signature
     * @return ValidateSignatureRequest
     */
    public function setSignature(string $signature): ValidateSignatureRequest
    {
        $this->signature = $signature;
        return $this;
    }
}
