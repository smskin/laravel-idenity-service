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
use SMSkin\IdentityService\Modules\Auth\Exceptions\VerificationAlreadyCanceled;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use Illuminate\Validation\ValidationException;

class CAssignPhoneToUserByCode extends BaseController
{
    protected AssignPhoneToUserByCodeRequest|BaseRequest|null $request;

    protected ?string $requestClass = AssignPhoneToUserByCodeRequest::class;

    /**
     * @return static
     * @throws InvalidPassword
     * @throws ThisIdentifyAlreadyUsesByAnotherUser
     * @throws UserAlreadyHasCredentialWithThisIdentify
     * @throws ValidationException
     * @throws VerificationAlreadyCanceled
     */
    public function execute(): static
    {
        $result = (new PhoneModule)->validateCredential(
            (new ValidateCredentialsRequest)
                ->setPhone($this->request->phone)
                ->setCode($this->request->code)
        );
        if (!$result) {
            throw new InvalidPassword();
        }

        $this->result = (new PhoneModule)->createCredential(
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
