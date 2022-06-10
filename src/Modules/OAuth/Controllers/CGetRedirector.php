<?php

namespace SMSkin\IdentityService\Modules\OAuth\Controllers;

use SMSkin\IdentityService\Modules\Auth\Exceptions\DisabledDriver;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\OAuth\Exceptions\DriverCredentialsNotDefined;
use SMSkin\IdentityService\Modules\OAuth\Exceptions\InvalidSignature;
use SMSkin\IdentityService\Modules\OAuth\Requests\GetRedirectorRequest;
use SMSkin\IdentityService\Modules\Signature\Requests\ValidateSignatureRequest;
use SMSkin\IdentityService\Modules\Signature\SignatureModule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;

class CGetRedirector extends BaseController
{
    public const SESSION_KEY = 'oauth-callback-data';

    protected GetRedirectorRequest|BaseRequest|null $request;

    protected ?string $requestClass = GetRedirectorRequest::class;

    /**
     * @return static
     * @throws DisabledDriver
     * @throws InvalidSignature
     * @throws ValidationException
     * @throws DriverCredentialsNotDefined
     */
    public function execute(): static
    {
        $this->validateSignature();
        $this->saveCallbackObject();
        $this->result = $this->getDriver()->getRedirector($this->request);
        return $this;
    }

    /**
     * @return RedirectResponse
     */
    public function getResult(): RedirectResponse
    {
        return parent::getResult();
    }

    private function saveCallbackObject()
    {
        Session::put(self::SESSION_KEY, $this->request->callback->toArray());
    }

    /**
     * @return void
     * @throws InvalidSignature
     * @throws ValidationException
     */
    private function validateSignature()
    {
        $result = (new SignatureModule)->validate(
            (new ValidateSignatureRequest)
                ->setValue(sha1($this->request->callback->url))
                ->setSalt($this->request->callback->key)
                ->setSignature($this->request->signature)
        );
        if (!$result) {
            throw new InvalidSignature();
        }
    }
}
