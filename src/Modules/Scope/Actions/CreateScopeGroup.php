<?php

namespace SMSkin\IdentityService\Modules\Scope\Actions;

use SMSkin\IdentityService\Models\ScopeGroup;
use SMSkin\LaravelSupport\BaseAction;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\Scope\Requests\CreateScopeGroupRequest;

class CreateScopeGroup extends BaseAction
{
    protected CreateScopeGroupRequest|BaseRequest|null $request;

    protected ?string $requestClass = CreateScopeGroupRequest::class;

    public function execute(): self
    {
        $scope = new ScopeGroup();
        $scope->name = $this->request->name;
        $scope->slug = $this->request->slug;
        $scope->save();

        $this->result = $scope;
        return $this;
    }

    /**
     * @return ScopeGroup
     */
    public function getResult(): ScopeGroup
    {
        return parent::getResult();
    }
}