<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;
use SMSkin\LaravelSupport\Rules\PhoneRule;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class AssignPhoneToUserRequest extends BaseRequest
{
    use ClassFromConfig;

    /**
     * @var User
     */
    public Model $user;
    public string $phone;

    public function rules(): array
    {
        return [
            'user' => [
                'required',
                new ExistsEloquentModelRule(self::getUserModelClass())
            ],
            'phone' => [
                'required',
                new PhoneRule()
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
}
