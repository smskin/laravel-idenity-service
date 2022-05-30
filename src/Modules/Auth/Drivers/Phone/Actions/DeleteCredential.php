<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Actions;

use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\ExistCredentialRequest;
use SMSkin\IdentityService\Modules\Core\BaseAction;
use SMSkin\IdentityService\Modules\Core\BaseRequest;

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
