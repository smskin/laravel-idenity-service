<?php

namespace SMSkin\IdentityService\Modules\Auth\Controllers;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Modules\Auth\Exceptions\DisabledDriver;
use SMSkin\IdentityService\Modules\Auth\Exceptions\InvalidPassword;
use SMSkin\IdentityService\Modules\Auth\Exceptions\RegistrationDisabled;
use SMSkin\IdentityService\Modules\Auth\Exceptions\ThisIdentifyAlreadyUsesByAnotherUser;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UnsupportedDriver;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UserAlreadyHasCredentialWithThisIdentify;
use SMSkin\IdentityService\Modules\Auth\Requests\RegisterRequest;
use SMSkin\LaravelSupport\BaseRequest;
use Throwable;

class CRegister extends BaseController
{
    protected RegisterRequest|BaseRequest|null $request;

    protected ?string $requestClass = RegisterRequest::class;

    /**
     * @return static
     * @throws UnsupportedDriver
     * @throws InvalidPassword
     * @throws ThisIdentifyAlreadyUsesByAnotherUser
     * @throws UserAlreadyHasCredentialWithThisIdentify
     * @throws RegistrationDisabled
     * @throws DisabledDriver
     * @throws Throwable
     */
    public function execute(): static
    {
        $this->validateConfig();
        $this->result = $this->getDriver()->register($this->request);

        return $this;
    }

    /**
     * @return User
     */
    public function getResult(): Model
    {
        return parent::getResult();
    }

    /**
     * @return void
     * @throws RegistrationDisabled
     */
    private function validateConfig()
    {
        if (!config('identity-service.modules.auth.registration.active', false))
        {
            throw new RegistrationDisabled();
        }
    }
}
