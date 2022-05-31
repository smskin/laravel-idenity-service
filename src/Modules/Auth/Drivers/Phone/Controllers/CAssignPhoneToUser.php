<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers;

use SMSkin\IdentityService\Models\UserPhoneCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\PhoneModule;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\AssignPhoneToUserRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\CreateCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Exceptions\ThisIdentifyAlreadyUsesByAnotherUser;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UserAlreadyHasCredentialWithThisIdentify;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use Illuminate\Validation\ValidationException;

class CAssignPhoneToUser extends BaseController
{
    protected AssignPhoneToUserRequest|BaseRequest|null $request;

    protected ?string $requestClass = AssignPhoneToUserRequest::class;

    /**
     * @return $this
     * @throws ThisIdentifyAlreadyUsesByAnotherUser
     * @throws UserAlreadyHasCredentialWithThisIdentify
     * @throws ValidationException
     */
    public function execute(): self
    {
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
