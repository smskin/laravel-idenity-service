<?php

namespace SMSkin\IdentityService\Modules\User;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Modules\User\Controllers\Scope\CAssignScopeToUser;
use SMSkin\IdentityService\Modules\User\Controllers\ScopeGroup\CAssignScopeGroupToUser;
use SMSkin\IdentityService\Modules\User\Requests\Scope\AssignScopeToUserRequest;
use SMSkin\IdentityService\Modules\User\Requests\ScopeGroup\AssignScopeGroupToUserRequest;
use SMSkin\LaravelSupport\BaseModule;
use SMSkin\IdentityService\Modules\User\Controllers\User\CCreateUser;
use SMSkin\IdentityService\Modules\User\Controllers\User\CUpdateUser;
use SMSkin\IdentityService\Modules\User\Controllers\User\ExecuteAfterNovaCreate;
use SMSkin\IdentityService\Modules\User\Requests\User\CreateUserRequest;
use SMSkin\IdentityService\Modules\User\Requests\User\ExistUserRequest;
use SMSkin\IdentityService\Modules\User\Requests\User\UpdateUserRequest;
use Illuminate\Validation\ValidationException;

class UserModule extends BaseModule
{
    /**
     * @param CreateUserRequest $request
     * @return User
     * @throws ValidationException
     */
    public function create(CreateUserRequest $request): Model
    {
        $request->validate();

        return (new CCreateUser($request))->execute()->getResult();
    }

    /**
     * @param ExistUserRequest $request
     * @return void
     * @throws ValidationException
     */
    public function executeAfterNovaCreated(ExistUserRequest $request): void
    {
        (new ExecuteAfterNovaCreate($request))->execute();
    }

    /**
     * @param UpdateUserRequest $request
     * @return User
     * @throws ValidationException
     */
    public function update(UpdateUserRequest $request): Model
    {
        $request->validate();

        return (new CUpdateUser($request))->execute()->getResult();
    }

    /**
     * @param AssignScopeGroupToUserRequest $request
     * @return void
     * @throws ValidationException
     * @throws Exceptions\ScopeGroupAlreadyAssigned
     */
    public function assignScopeGroup(AssignScopeGroupToUserRequest $request)
    {
        (new CAssignScopeGroupToUser($request))->execute();
    }

    /**
     * @param AssignScopeToUserRequest $request
     * @return void
     * @throws ValidationException
     * @throws Exceptions\ScopeAlreadyAssigned
     */
    public function assignScope(AssignScopeToUserRequest $request)
    {
        (new CAssignScopeToUser($request))->execute();
    }
}
