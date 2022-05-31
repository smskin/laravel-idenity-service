<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests;

use SMSkin\LaravelSupport\BaseRequest;

class ValidateCredentialRequest extends BaseRequest
{
    public string $email;
    public string $password;

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email'
            ],
            'password' => [
                'required'
            ]
        ];
    }

    /**
     * @param string $email
     * @return ValidateCredentialRequest
     */
    public function setEmail(string $email): ValidateCredentialRequest
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $password
     * @return ValidateCredentialRequest
     */
    public function setPassword(string $password): ValidateCredentialRequest
    {
        $this->password = $password;
        return $this;
    }
}
