<?php

namespace SMSkin\IdentityService\Modules\User\Actions\User;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Modules\Core\BaseAction;
use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\User\Requests\User\CreateUserRequest;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class CreateUserContext extends BaseAction
{
    use ClassFromConfig;

    protected CreateUserRequest|BaseRequest|null $request;

    protected ?string $requestClass = CreateUserRequest::class;

    public function execute(): self
    {
        $user = $this->getUserModel();
        $user->name = $this->request->name;
        $user->save();

        $this->result = $user;
        return $this;
    }

    /**
     * @return User
     */
    public function getResult(): Model
    {
        return parent::getResult();
    }
}