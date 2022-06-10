<?php

namespace SMSkin\IdentityService\Modules\User\Actions\ScopeGroup;

use SMSkin\IdentityService\Modules\User\Requests\ScopeGroup\AssignScopeGroupToUserRequest;
use SMSkin\LaravelSupport\BaseAction;
use SMSkin\LaravelSupport\BaseRequest;

class AssignScopeGroupToUser extends BaseAction
{
    protected AssignScopeGroupToUserRequest|BaseRequest|null $request;

    protected ?string $requestClass = AssignScopeGroupToUserRequest::class;

    public function execute(): static
    {
        $this->request->user->scopeGroups()->attach($this->request->group);
        return $this;
    }
}
