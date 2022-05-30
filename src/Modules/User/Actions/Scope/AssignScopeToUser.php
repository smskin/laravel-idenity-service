<?php

namespace SMSkin\IdentityService\Modules\User\Actions\Scope;

use SMSkin\IdentityService\Modules\Core\BaseAction;
use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\User\Requests\Scope\AssignScopeToUserRequest;

class AssignScopeToUser extends BaseAction
{
    protected AssignScopeToUserRequest|BaseRequest|null $request;

    protected ?string $requestClass = AssignScopeToUserRequest::class;

    public function execute(): self
    {
        $this->request->user->scopes()->attach($this->request->scope);
        return $this;
    }
}
