<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\Core\Rules\ExistsEloquentModelRule;
use SMSkin\IdentityService\Modules\Core\Rules\PhoneRule;
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
                new ExistsEloquentModelRule($this->getUserModelClass())
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
