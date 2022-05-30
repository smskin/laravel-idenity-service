<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\Core\Rules\ExistsEloquentModelRule;
use SMSkin\IdentityService\Modules\Core\Rules\PhoneRule;
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
