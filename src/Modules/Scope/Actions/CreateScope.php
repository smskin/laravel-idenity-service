<?php

namespace SMSkin\IdentityService\Modules\Scope\Actions;

use SMSkin\IdentityService\Models\Scope;
use SMSkin\LaravelSupport\BaseAction;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\Scope\Requests\CreateScopeRequest;

class CreateScope extends BaseAction
{
    protected CreateScopeRequest|BaseRequest|null $request;

    protected ?string $requestClass = CreateScopeRequest::class;

    public function execute(): static
    {
        $scope = new Scope();
        $scope->group_id = $this->request->group->id;
        $scope->name = $this->request->name;
        $scope->slug = $this->request->slug;
        $scope->save();

        $this->result = $scope;
        return $this;
    }

    /**
     * @return Scope
     */
    public function getResult(): Scope
    {
        return parent::getResult();
    }
}