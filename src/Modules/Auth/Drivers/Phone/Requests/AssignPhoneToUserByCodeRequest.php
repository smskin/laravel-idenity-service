<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;
use SMSkin\LaravelSupport\Rules\PhoneRule;
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
                new ExistsEloquentModelRule(self::getUserModelClass())
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
