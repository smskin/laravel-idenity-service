<?php

namespace SMSkin\IdentityService\Modules\Auth\Requests;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class AssignEmailToUserRequest extends \SMSkin\LaravelSupport\BaseRequest
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
                new ExistsEloquentModelRule(self::getUserModelClass())
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
     * @return AssignEmailToUserRequest
     */
    public function setUser(Model $user): AssignEmailToUserRequest
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param string $email
     * @return AssignEmailToUserRequest
     */
    public function setEmail(string $email): AssignEmailToUserRequest
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $password
     * @return AssignEmailToUserRequest
     */
    public function setPassword(string $password): AssignEmailToUserRequest
    {
        $this->password = $password;
        return $this;
    }
}
