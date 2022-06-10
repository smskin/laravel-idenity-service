<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers;

use Illuminate\Validation\ValidationException;
use SMSkin\IdentityService\Modules\Auth\Controllers\BaseController;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Actions\DeleteCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\ExistCredentialRequest;
use SMSkin\LaravelSupport\BaseRequest;

class CDeleteCredential extends BaseController
{
    protected ExistCredentialRequest|BaseRequest|null $request;

    protected ?string $requestClass = ExistCredentialRequest::class;

    /**
     * @return $this
     * @throws ValidationException
     */
    public function execute(): static
    {
        (new DeleteCredential($this->request))->execute();
        return $this;
    }
}
