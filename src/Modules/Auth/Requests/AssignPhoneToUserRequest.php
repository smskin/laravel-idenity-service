<?php

namespace SMSkin\IdentityService\Modules\Auth\Requests;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;
use SMSkin\LaravelSupport\Rules\PhoneRule;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class AssignPhoneToUserRequest extends \SMSkin\LaravelSupport\BaseRequest
{
    use ClassFromConfig;

    /**
     * @var User
     */
    public Model $user;
    public string $phone;
    public string $code;

    public function rules(): array
    {
        return [
            'user' => [
                'required',
                new ExistsEloquentModelRule($this->getUserModelClass())
            ],
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
     * @param User $user
     * @return AssignPhoneToUserRequest
     */
    public function setUser(Model $user): AssignPhoneToUserRequest
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param string $phone
     * @return AssignPhoneToUserRequest
     */
    public function setPhone(string $phone): AssignPhoneToUserRequest
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @param string $code
     * @return AssignPhoneToUserRequest
     */
    public function setCode(string $code): AssignPhoneToUserRequest
    {
        $this->code = $code;
        return $this;
    }
}
