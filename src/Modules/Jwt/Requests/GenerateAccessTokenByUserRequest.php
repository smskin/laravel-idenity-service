<?php

namespace SMSkin\IdentityService\Modules\Jwt\Requests;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class GenerateAccessTokenByUserRequest extends BaseRequest
{
    use ClassFromConfig;

    /**
     * @var User
     */
    public Model $user;
    public array $scopes;

    public function rules(): array
    {
        return [
            'user' => [
                'required',
                new ExistsEloquentModelRule($this->getUserModelClass())
            ],
            'scopes' => [
                'required',
                'array'
            ]
        ];
    }

    /**
     * @param User $user
     * @return GenerateAccessTokenByUserRequest
     */
    public function setUser(Model $user): GenerateAccessTokenByUserRequest
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param array $scopes
     * @return GenerateAccessTokenByUserRequest
     */
    public function setScopes(array $scopes): GenerateAccessTokenByUserRequest
    {
        $this->scopes = $scopes;
        return $this;
    }
}
