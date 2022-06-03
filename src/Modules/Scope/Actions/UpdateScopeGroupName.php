<?php

namespace SMSkin\IdentityService\Modules\Scope\Actions;

use SMSkin\LaravelSupport\BaseAction;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\Scope\Requests\UpdateScopeGroupNameRequest;

class UpdateScopeGroupName extends BaseAction
{
    protected UpdateScopeGroupNameRequest|BaseRequest|null $request;

    protected ?string $requestClass = UpdateScopeGroupNameRequest::class;

    public function execute(): static
    {
        $group = $this->request->group;

        $group->name = $this->request->name;
        $group->save();
        return $this;
    }
}