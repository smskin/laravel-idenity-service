<?php

namespace SMSkin\IdentityService\Modules\User;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Modules\Core\BaseModule;
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

        return app(CCreateUser::class, [
            'request' => $request
        ])->execute()->getResult();
    }

    public function executeAfterNovaCreated(ExistUserRequest $request): void
    {
        app(ExecuteAfterNovaCreate::class, [
            'request' => $request
        ])->execute();
    }

    /**
     * @param UpdateUserRequest $request
     * @return User
     * @throws ValidationException
     */
    public function update(UpdateUserRequest $request): Model
    {
        $request->validate();

        return app(CUpdateUser::class, [
            'request' => $request
        ])->execute()->getResult();
    }
}
