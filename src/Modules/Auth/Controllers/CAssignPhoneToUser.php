<?php

namespace SMSkin\IdentityService\Modules\Auth\Controllers;

use SMSkin\IdentityService\Models\UserPhoneCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\PhoneModule;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\AssignPhoneToUserByCodeRequest;
use SMSkin\IdentityService\Modules\Auth\Enums\DriverEnum;
use SMSkin\IdentityService\Modules\Auth\Exceptions\DisabledDriver;
use SMSkin\IdentityService\Modules\Auth\Exceptions\InvalidPassword;
use SMSkin\IdentityService\Modules\Auth\Exceptions\ThisIdentifyAlreadyUsesByAnotherUser;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UserAlreadyHasCredentialWithThisIdentify;
use SMSkin\IdentityService\Modules\Auth\Requests\AssignPhoneToUserRequest;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use Illuminate\Validation\ValidationException;

class CAssignPhoneToUser extends BaseController
{
    protected AssignPhoneToUserRequest|BaseRequest|null $request;

    protected ?string $requestClass = AssignPhoneToUserRequest::class;

    /**
     * @return $this
     * @throws DisabledDriver
     * @throws InvalidPassword
     * @throws ThisIdentifyAlreadyUsesByAnotherUser
     * @throws UserAlreadyHasCredentialWithThisIdentify
     * @throws ValidationException
     */
    public function execute(): self
    {
        $this->validateDriver();
        $this->result = app(PhoneModule::class)->assignPhoneToUserByCode(
            (new AssignPhoneToUserByCodeRequest())
                ->setUser($this->request->user)
                ->setPhone($this->request->phone)
                ->setCode($this->request->code)
        );

        return $this;
    }

    /**
     * @return UserPhoneCredential
     */
    public function getResult(): UserPhoneCredential
    {
        return parent::getResult();
    }

    /**
     * @return void
     * @throws DisabledDriver
     */
    private function validateDriver()
    {
        if (!in_array(DriverEnum::PHONE, config('identity-service.modules.auth.auth.drivers', []))) {
            throw new DisabledDriver();
        }
    }
}
