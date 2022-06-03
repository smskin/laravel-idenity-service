<?php

namespace SMSkin\IdentityService\Modules\Scope\Actions;

use SMSkin\LaravelSupport\BaseAction;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\Scope\Requests\UpdateScopeNameRequest;

class UpdateScopeName extends BaseAction
{
    protected UpdateScopeNameRequest|BaseRequest|null $request;

    protected ?string $requestClass = UpdateScopeNameRequest::class;

    public function execute(): static
    {
        $scope = $this->request->scope;

        $scope->name = $this->request->name;
        $scope->save();
        return $this;
    }
}