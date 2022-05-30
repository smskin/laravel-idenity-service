<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\Core\Rules\ExistsEloquentModelRule;
use SMSkin\IdentityService\Modules\Core\Rules\PhoneRule;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class AssignPhoneToUserByCodeRequest extends BaseRequest
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
     * @return AssignPhoneToUserByCodeRequest
     */
    public function setUser(Model $user): AssignPhoneToUserByCodeRequest
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param string $phone
     * @return AssignPhoneToUserByCodeRequest
     */
    public function setPhone(string $phone): AssignPhoneToUserByCodeRequest
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @param string $code
     * @return AssignPhoneToUserByCodeRequest
     */
    public function setCode(string $code): AssignPhoneToUserByCodeRequest
    {
        $this->code = $code;
        return $this;
    }
}
