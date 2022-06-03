<?php

namespace SMSkin\IdentityService\Modules\User\Actions\User;

use Illuminate\Database\Eloquent\Model;
use SMSkin\LaravelSupport\BaseAction;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\User\Requests\User\UpdateUserRequest;
use Illuminate\Foundation\Auth\User;

class UpdateUserContext extends BaseAction
{
    protected UpdateUserRequest|BaseRequest|null $request;

    protected ?string $requestClass = UpdateUserRequest::class;

    public function execute(): static
    {
        $request = $this->request;
        $user = $request->user;
        if ($request->isChanged($request::NAME)) {
            $user->name = $request->name;
        }
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
