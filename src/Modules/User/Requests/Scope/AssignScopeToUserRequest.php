<?php

namespace SMSkin\IdentityService\Modules\User\Requests\Scope;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\Scope;
use SMSkin\IdentityService\Models\User;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class AssignScopeToUserRequest extends BaseRequest
{
    use ClassFromConfig;

    /**
     * @var User
     */
    public Model $user;
    public Scope $scope;

    public function rules(): array
    {
        return [
            'user' => [
                'required',
                new ExistsEloquentModelRule($this->getUserModelClass())
            ],
            'scope' => [
                'required',
                new ExistsEloquentModelRule(Scope::class)
            ]
        ];
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(Model $user): AssignScopeToUserRequest
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param Scope $scope
     * @return AssignScopeToUserRequest
     */
    public function setScope(Scope $scope): AssignScopeToUserRequest
    {
        $this->scope = $scope;
        return $this;
    }
}
