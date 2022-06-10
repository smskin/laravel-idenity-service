<?php

namespace SMSkin\IdentityService\Modules\User\Requests\ScopeGroup;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\ScopeGroup;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Traits\ClassFromConfig;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\LaravelSupport\Rules\ExistsEloquentModelRule;

class AssignScopeGroupToUserRequest extends BaseRequest
{
    use ClassFromConfig;

    /**
     * @var User
     */
    public Model $user;
    public ScopeGroup $group;

    public function rules(): array
    {
        return [
            'user' => [
                'required',
                new ExistsEloquentModelRule(self::getUserModelClass())
            ],
            'group' => [
                'required',
                new ExistsEloquentModelRule(ScopeGroup::class)
            ]
        ];
    }

    /**
     * @param User $user
     * @return static
     */
    public function setUser(Model $user): AssignScopeGroupToUserRequest
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param ScopeGroup $group
     * @return AssignScopeGroupToUserRequest
     */
    public function setGroup(ScopeGroup $group): AssignScopeGroupToUserRequest
    {
        $this->group = $group;
        return $this;
    }
}