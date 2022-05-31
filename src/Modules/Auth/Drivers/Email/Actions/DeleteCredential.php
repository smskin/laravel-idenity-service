<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Actions;

use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\ExistCredentialRequest;
use SMSkin\LaravelSupport\BaseAction;
use SMSkin\LaravelSupport\BaseRequest;

class DeleteCredential extends BaseAction
{
    protected ExistCredentialRequest|BaseRequest|null $request;

    protected ?string $requestClass = ExistCredentialRequest::class;

    public function execute(): self
    {
        $credential = $this->request->credential;
        $credential->delete();
        return $this;
    }
}
