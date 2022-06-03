<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Controllers;

use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Actions\DeleteCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\ExistCredentialRequest;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;

class CDeleteCredential extends BaseController
{
    protected ExistCredentialRequest|BaseRequest|null $request;

    protected ?string $requestClass = ExistCredentialRequest::class;

    public function execute(): static
    {
        app(DeleteCredential::class, [
            'request' => $this->request
        ])->execute();
        return $this;
    }
}
