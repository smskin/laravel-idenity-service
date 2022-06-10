<?php

namespace SMSkin\IdentityService\Modules\User\Controllers\User;

use Illuminate\Validation\ValidationException;
use SMSkin\IdentityService\Models\Scope;
use SMSkin\IdentityService\Modules\User\Controllers\Scope\CAssignScopeToUser;
use SMSkin\IdentityService\Modules\User\Exceptions\ScopeAlreadyAssigned;
use SMSkin\IdentityService\Modules\User\UserModule;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\User\Requests\Scope\AssignScopeToUserRequest;
use SMSkin\IdentityService\Modules\User\Requests\User\ExistUserRequest;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class ExecuteAfterNovaCreate extends BaseController
{
    use ClassFromConfig;

    protected ExistUserRequest|BaseRequest|null $request;

    protected ?string $requestClass = ExistUserRequest::class;

    /**
     * @return $this
     * @throws ValidationException
     */
    public function execute(): static
    {
        $this->appendDefaultScope();
        return $this;
    }

    /**
     * @return void
     * @throws ValidationException
     */
    private function appendDefaultScope(): void
    {
        try {
            (new UserModule())->assignScope(
                (new AssignScopeToUserRequest)
                    ->setUser($this->request->user)
                    ->setScope(Scope::where('slug', self::getSystemChangeScope())->firstOrFail())
            );
        } catch (ScopeAlreadyAssigned) {
            // not possible
        }
    }
}
