<?php

namespace SMSkin\IdentityService\Modules\Auth\Controllers;

use SMSkin\IdentityService\Models\UserEmailCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\EmailModule;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\CreateCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Enums\DriverEnum;
use SMSkin\IdentityService\Modules\Auth\Exceptions\DisabledDriver;
use SMSkin\IdentityService\Modules\Auth\Exceptions\ThisIdentifyAlreadyUsesByAnotherUser;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UserAlreadyHasCredentialWithThisIdentify;
use SMSkin\IdentityService\Modules\Auth\Requests\AssignEmailToUserRequest;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use Illuminate\Validation\ValidationException;

class CAssignEmail extends BaseController
{
    protected AssignEmailToUserRequest|BaseRequest|null $request;

    protected ?string $requestClass = AssignEmailToUserRequest::class;

    /**
     * @return static
     * @throws DisabledDriver
     * @throws ThisIdentifyAlreadyUsesByAnotherUser
     * @throws UserAlreadyHasCredentialWithThisIdentify
     * @throws ValidationException
     */
    public function execute(): static
    {
        $this->validateDriver();
        $this->result = app(EmailModule::class)->createCredential(
            (new CreateCredentialRequest)
                ->setUser($this->request->user)
                ->setEmail($this->request->email)
                ->setPassword($this->request->password)
        );

        return $this;
    }

    /**
     * @return UserEmailCredential
     */
    public function getResult(): UserEmailCredential
    {
        return parent::getResult();
    }

    /**
     * @return void
     * @throws DisabledDriver
     */
    private function validateDriver()
    {
        if (!in_array(DriverEnum::EMAIL, config('identity-service.modules.auth.auth.drivers', [])))
        {
            throw new DisabledDriver();
        }
    }
}
