<?php

namespace SMSkin\IdentityService\Modules\User\Controllers\User;

use SMSkin\IdentityService\Models\Scope;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\User\Actions\Scope\AssignScopeToUser;
use SMSkin\IdentityService\Modules\User\Requests\Scope\AssignScopeToUserRequest;
use SMSkin\IdentityService\Modules\User\Requests\User\ExistUserRequest;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class ExecuteAfterNovaCreate extends BaseController
{
    use ClassFromConfig;

    protected ExistUserRequest|BaseRequest|null $request;

    protected ?string $requestClass = ExistUserRequest::class;

    public function execute(): static
    {
        $this->appendDefaultScope();
        return $this;
    }

    private function appendDefaultScope(): void
    {
        app(AssignScopeToUser::class, [
            'request' => (new AssignScopeToUserRequest)
                ->setUser($this->request->user)
                ->setScope(Scope::where('slug', $this->getSystemChangeScope())->firstOrFail())
        ])->execute();
    }
}
