<?php

namespace SMSkin\IdentityService\Modules\Auth\Controllers;

use SMSkin\IdentityService\Modules\Auth\Exceptions\CredentialWithThisIdentifyNotExists;
use SMSkin\IdentityService\Modules\Auth\Exceptions\DisabledDriver;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UnsupportedDriver;
use SMSkin\IdentityService\Modules\Auth\Requests\DeleteCredentialRequest;
use SMSkin\LaravelSupport\BaseRequest;
use Illuminate\Validation\ValidationException;

class CDeleteCredential extends BaseController
{
    protected DeleteCredentialRequest|BaseRequest|null $request;

    protected ?string $requestClass = DeleteCredentialRequest::class;

    /**
     * @return BaseController
     * @throws CredentialWithThisIdentifyNotExists
     * @throws DisabledDriver
     * @throws UnsupportedDriver
     * @throws ValidationException
     */
    public function execute(): BaseController
    {
        $this->getDriver()->deleteCredential($this->request);

        return $this;
    }
}
