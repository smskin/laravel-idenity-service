<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\Core\Rules\ExistsEloquentModelRule;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class UpdatePasswordRequest extends BaseRequest
{
    use ClassFromConfig;

    /**
     * @var User
     */
    public Model $user;
    public string $email;
    public string $password;

    public function rules(): array
    {
        return [
            'user' => [
                'required',
                new ExistsEloquentModelRule($this->getUserModelClass())
            ],
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
     * @param User $user
     * @return UpdatePasswordRequest
     */
    public function setUser(Model $user): UpdatePasswordRequest
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param string $email
     * @return UpdatePasswordRequest
     */
    public function setEmail(string $email): UpdatePasswordRequest
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $password
     * @return UpdatePasswordRequest
     */
    public function setPassword(string $password): UpdatePasswordRequest
    {
        $this->password = $password;
        return $this;
    }
}
