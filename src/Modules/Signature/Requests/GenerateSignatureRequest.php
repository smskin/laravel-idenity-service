<?php

namespace SMSkin\IdentityService\Modules\Signature\Requests;

use SMSkin\LaravelSupport\BaseRequest;

class GenerateSignatureRequest extends BaseRequest
{
    public string $value;
    public string $salt;

    public function rules(): array
    {
        return [
            'value' => [
                'required'
            ],
            'salt' => [
                'required'
            ]
        ];
    }

    /**
     * @param string $value
     * @return GenerateSignatureRequest
     */
    public function setValue(string $value): GenerateSignatureRequest
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param string $salt
     * @return GenerateSignatureRequest
     */
    public function setSalt(string $salt): GenerateSignatureRequest
    {
        $this->salt = $salt;
        return $this;
    }
}
