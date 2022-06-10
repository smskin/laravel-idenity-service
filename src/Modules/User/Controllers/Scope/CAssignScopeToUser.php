<?php

namespace SMSkin\IdentityService\Modules\User\Controllers\Scope;

use Illuminate\Validation\ValidationException;
use SMSkin\IdentityService\Modules\User\Actions\Scope\AssignScopeToUser;
use SMSkin\IdentityService\Modules\User\Exceptions\ScopeAlreadyAssigned;
use SMSkin\IdentityService\Modules\User\Requests\Scope\AssignScopeToUserRequest;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;

class CAssignScopeToUser extends BaseController
{
    protected AssignScopeToUserRequest|BaseRequest|null $request;

    protected ?string $requestClass = AssignScopeToUserRequest::class;

    /**
     * @return $this
     * @throws ValidationException
     * @throws ScopeAlreadyAssigned
     */
    public function execute(): static
    {
        $this->validateState();
        (new AssignScopeToUser($this->request))->execute();
        return $this;
    }

    /**
     * @return void
     * @throws ScopeAlreadyAssigned
     */
    private function validateState()
    {
        $exists = $this->request->user->scopes()->where('scope_id', $this->request->scope->id)->exists();
        if ($exists) {
            throw new ScopeAlreadyAssigned();
        }
    }
}