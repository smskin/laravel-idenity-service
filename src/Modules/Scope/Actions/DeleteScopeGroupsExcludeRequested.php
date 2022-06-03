<?php

namespace SMSkin\IdentityService\Modules\Scope\Actions;

use SMSkin\IdentityService\Models\ScopeGroup;
use SMSkin\LaravelSupport\BaseAction;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\Scope\Requests\DeleteScopesGroupsExcludeRequestedRequest;

class DeleteScopeGroupsExcludeRequested extends BaseAction
{
    protected DeleteScopesGroupsExcludeRequestedRequest|BaseRequest|null $request;

    protected ?string $requestClass = DeleteScopesGroupsExcludeRequestedRequest::class;

    public function execute(): static
    {
        ScopeGroup::whereNotIn('id', $this->request->ids)->delete();
        return $this;
    }
}