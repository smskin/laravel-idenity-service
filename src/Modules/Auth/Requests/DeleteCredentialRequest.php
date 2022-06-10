<?php

namespace SMSkin\IdentityService\Modules\Auth\Requests;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class DeleteCredentialRequest extends BaseRequest
{
    use ClassFromConfig;

    /**
     * @var User
     */
    public Model $user;

    public string $identify;

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                'user' => [
                    'required',
                    new ExistsEloquentModelRule(self::getUserModelClass())
                ],
                'identify' => [
                    'required'
                ]
            ]
        );
    }

    /**
     * @param string $identify
     * @return DeleteCredentialRequest
     */
    public function setIdentify(string $identify): DeleteCredentialRequest
    {
        $this->identify = $identify;
        return $this;
    }

    /**
     * @param User $user
     * @return DeleteCredentialRequest
     */
    public function setUser(Model $user): DeleteCredentialRequest
    {
        $this->user = $user;
        return $this;
    }
}
