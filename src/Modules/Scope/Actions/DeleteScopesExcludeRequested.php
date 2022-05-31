<?php

namespace SMSkin\IdentityService\Modules\Scope\Actions;

use SMSkin\IdentityService\Models\Scope;
use SMSkin\LaravelSupport\BaseAction;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\Scope\Requests\DeleteScopesExcludeRequestedRequest;

class DeleteScopesExcludeRequested extends BaseAction
{
    protected DeleteScopesExcludeRequestedRequest|BaseRequest|null $request;

    protected ?string $requestClass = DeleteScopesExcludeRequestedRequest::class;

    public function execute(): self
    {
        Scope::whereNotIn('id', $this->request->ids)->delete();
        return $this;
    }
}