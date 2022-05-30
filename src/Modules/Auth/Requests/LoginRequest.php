<?php

namespace SMSkin\IdentityService\Modules\Auth\Requests;

class LoginRequest extends BaseRequest
{
    public string $identify;
    public string $password;
    public array $scopes;

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
                ],
                'scopes' => [
                    'required',
                    'array'
                ]
            ]
        );
    }

    /**
     * @param string $identify
     * @return LoginRequest
     */
    public function setIdentify(string $identify): LoginRequest
    {
        $this->identify = $identify;
        return $this;
    }

    /**
     * @param string $password
     * @return LoginRequest
     */
    public function setPassword(string $password): LoginRequest
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param array $scopes
     * @return LoginRequest
     */
    public function setScopes(array $scopes): LoginRequest
    {
        $this->scopes = $scopes;
        return $this;
    }
}
