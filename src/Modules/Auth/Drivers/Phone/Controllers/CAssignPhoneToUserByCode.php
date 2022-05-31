<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers;

use SMSkin\IdentityService\Models\UserPhoneCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\PhoneModule;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\AssignPhoneToUserByCodeRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\CreateCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\ValidateCredentialsRequest;
use SMSkin\IdentityService\Modules\Auth\Exceptions\InvalidPassword;
use SMSkin\IdentityService\Modules\Auth\Exceptions\ThisIdentifyAlreadyUsesByAnotherUser;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UserAlreadyHasCredentialWithThisIdentify;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use Illuminate\Validation\ValidationException;

class CAssignPhoneToUserByCode extends BaseController
{
    protected AssignPhoneToUserByCodeRequest|BaseRequest|null $request;

    protected ?string $requestClass = AssignPhoneToUserByCodeRequest::class;

    /**
     * @return $this
     * @throws InvalidPassword
     * @throws ThisIdentifyAlreadyUsesByAnotherUser
     * @throws UserAlreadyHasCredentialWithThisIdentify
     * @throws ValidationException
     */
    public function execute(): self
    {
        $result = app(PhoneModule::class)->validateCredential(
            (new ValidateCredentialsRequest)
                ->setPhone($this->request->phone)
                ->setCode($this->request->code)
        );
        if (!$result) {
            throw new InvalidPassword();
        }

        $this->result = app(PhoneModule::class)->createCredential(
            (new CreateCredentialRequest)
                ->setUser($this->request->user)
                ->setPhone($this->request->phone)
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
}
