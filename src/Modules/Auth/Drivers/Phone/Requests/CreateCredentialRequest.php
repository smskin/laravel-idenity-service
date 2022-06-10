<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;
use SMSkin\LaravelSupport\Rules\PhoneRule;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class CreateCredentialRequest extends BaseRequest
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
     * @return CreateCredentialRequest
     */
    public function setUser(Model $user): CreateCredentialRequest
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param string $phone
     * @return CreateCredentialRequest
     */
    public function setPhone(string $phone): CreateCredentialRequest
    {
        $this->phone = $phone;
        return $this;
    }
}
