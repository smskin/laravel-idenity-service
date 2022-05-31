<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers;

use SMSkin\IdentityService\Modules\Auth\Controllers\BaseController;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Actions\DeleteCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\ExistCredentialRequest;
use SMSkin\LaravelSupport\BaseRequest;

class CDeleteCredential extends BaseController
{
    protected ExistCredentialRequest|BaseRequest|null $request;

    protected ?string $requestClass = ExistCredentialRequest::class;

    public function execute(): self
    {
        app(DeleteCredential::class, [
            'request' => $this->request
        ])->execute();
        return $this;
    }
}
