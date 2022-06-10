<?php

namespace SMSkin\IdentityService\Modules\User\Controllers\User;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\Scope;
use SMSkin\IdentityService\Models\User;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\User\Actions\Scope\AssignScopeToUser;
use SMSkin\IdentityService\Modules\User\Actions\User\CreateUserContext;
use SMSkin\IdentityService\Modules\User\Requests\Scope\AssignScopeToUserRequest;
use SMSkin\IdentityService\Modules\User\Requests\User\CreateUserRequest;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class CCreateUser extends BaseController
{
    use ClassFromConfig;

    protected CreateUserRequest|BaseRequest|null $request;

    protected ?string $requestClass = CreateUserRequest::class;

    public function execute(): static
    {
        $user = $this->createUser();
        $this->appendDefaultScope($user);

        $this->result = $user;
        return $this;
    }

    private function appendDefaultScope(Model $user)
    {
        app(AssignScopeToUser::class, [
            'request' => (new AssignScopeToUserRequest)
                ->setUser($user)
                ->setScope(Scope::where('slug', self::getSystemChangeScope())->firstOrFail())
        ])->execute();
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
     */
    private function createUser(): Model
    {
        return app(CreateUserContext::class, [
            'request' => $this->request
        ])->execute()->getResult();
    }
}
