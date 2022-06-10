<?php

namespace SMSkin\IdentityService\Modules\User\Controllers\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use SMSkin\IdentityService\Models\Scope;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Modules\User\Controllers\Scope\CAssignScopeToUser;
use SMSkin\IdentityService\Modules\User\Exceptions\ScopeAlreadyAssigned;
use SMSkin\IdentityService\Modules\User\UserModule;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\User\Actions\User\CreateUserContext;
use SMSkin\IdentityService\Modules\User\Requests\Scope\AssignScopeToUserRequest;
use SMSkin\IdentityService\Modules\User\Requests\User\CreateUserRequest;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class CCreateUser extends BaseController
{
    use ClassFromConfig;

    protected CreateUserRequest|BaseRequest|null $request;

    protected ?string $requestClass = CreateUserRequest::class;

    /**
     * @return $this
     * @throws ValidationException
     */
    public function execute(): static
    {
        $user = $this->createUser();
        $this->appendDefaultScope($user);

        $this->result = $user;
        return $this;
    }

    /**
     * @param Model $user
     * @return void
     * @throws ValidationException
     */
    private function appendDefaultScope(Model $user)
    {
        try {
            (new UserModule())->assignScope(
                (new AssignScopeToUserRequest)
                    ->setUser($user)
                    ->setScope(Scope::where('slug', self::getSystemChangeScope())->firstOrFail())
            );
        } catch (ScopeAlreadyAssigned) {
            // not possible
        }
    }

    /**
     * @return User
     */
    public function getResult(): Model
    {
        return parent::getResult();
    }

    /**
     * @return User
     * @throws ValidationException
     */
    private function createUser(): Model
    {
        return (new CreateUserContext($this->request))->execute()->getResult();
    }
}
