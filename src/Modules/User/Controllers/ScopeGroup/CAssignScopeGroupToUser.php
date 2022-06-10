<?php

namespace SMSkin\IdentityService\Modules\User\Controllers\ScopeGroup;

use Illuminate\Validation\ValidationException;
use SMSkin\IdentityService\Modules\User\Actions\ScopeGroup\AssignScopeGroupToUser;
use SMSkin\IdentityService\Modules\User\Exceptions\ScopeGroupAlreadyAssigned;
use SMSkin\IdentityService\Modules\User\Requests\ScopeGroup\AssignScopeGroupToUserRequest;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;

class CAssignScopeGroupToUser extends BaseController
{
    protected AssignScopeGroupToUserRequest|BaseRequest|null $request;

    protected ?string $requestClass = AssignScopeGroupToUserRequest::class;

    /**
     * @return $this
     * @throws ValidationException
     * @throws ScopeGroupAlreadyAssigned
     */
    public function execute(): static
    {
        $this->validateState();
        (new AssignScopeGroupToUser($this->request))->execute();
        return $this;
    }

    /**
     * @return void
     * @throws ScopeGroupAlreadyAssigned
     */
    private function validateState()
    {
        $exists = $this->request->user->scopeGroups()->where('group_id', $this->request->group->id)->exists();
        if ($exists) {
            throw new ScopeGroupAlreadyAssigned();
        }
    }
}