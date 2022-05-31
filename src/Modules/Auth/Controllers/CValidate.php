<?php

namespace SMSkin\IdentityService\Modules\Auth\Controllers;

use SMSkin\IdentityService\Modules\Auth\Exceptions\DisabledDriver;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UnsupportedDriver;
use SMSkin\IdentityService\Modules\Auth\Requests\ValidateRequest;
use SMSkin\LaravelSupport\BaseRequest;
use Illuminate\Validation\ValidationException;

class CValidate extends BaseController
{
    protected ValidateRequest|BaseRequest|null $request;

    protected ?string $requestClass = ValidateRequest::class;

    /**
     * @return CValidate
     * @throws DisabledDriver
     * @throws UnsupportedDriver
     * @throws ValidationException
     */
    public function execute(): self
    {
        $this->result = $this->getDriver()->validate($this->request);

        return $this;
    }

    /**
     * @return bool
     */
    public function getResult(): bool
    {
        return parent::getResult();
    }
}
