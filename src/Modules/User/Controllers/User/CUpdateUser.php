<?php

namespace SMSkin\IdentityService\Modules\User\Controllers\User;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\User\Actions\User\UpdateUserContext;
use SMSkin\IdentityService\Modules\User\Requests\User\UpdateUserRequest;

class CUpdateUser extends BaseController
{
    protected UpdateUserRequest|BaseRequest|null $request;

    protected ?string $requestClass = UpdateUserRequest::class;

    public function execute(): static
    {
        $this->result = app(UpdateUserContext::class, [
            'request'=>$this->request
        ])->execute()->getResult();
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
