<?php

namespace SMSkin\IdentityService\Modules\Auth\Requests;

class RegisterRequest extends BaseRequest
{
    public string $name;
    public string $identify;
    public string $password;

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                'name' => [
                    'required'
                ],
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
     * @return RegisterRequest
     */
    public function setIdentify(string $identify): RegisterRequest
    {
        $this->identify = $identify;
        return $this;
    }

    /**
     * @param string $password
     * @return RegisterRequest
     */
    public function setPassword(string $password): RegisterRequest
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param string $name
     * @return RegisterRequest
     */
    public function setName(string $name): RegisterRequest
    {
        $this->name = $name;
        return $this;
    }
}
