<?php

namespace SMSkin\IdentityService\Modules\Auth\Requests;

class ValidateRequest extends BaseRequest
{
    public string $identify;
    public string $password;

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                'identify' => [
                    'required'
                ],
                'password' => [
                    'required'
                ]
            ]
        );
    }

    /**
     * @param string $identify
     * @return ValidateRequest
     */
    public function setIdentify(string $identify): ValidateRequest
    {
        $this->identify = $identify;
        return $this;
    }

    /**
     * @param string $password
     * @return ValidateRequest
     */
    public function setPassword(string $password): ValidateRequest
    {
        $this->password = $password;
        return $this;
    }
}
