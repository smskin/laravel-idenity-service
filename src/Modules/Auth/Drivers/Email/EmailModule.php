<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email;

use SMSkin\IdentityService\Models\UserEmailCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Controllers\CCreateCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Controllers\CDeleteCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Controllers\CUpdatePassword;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Controllers\CValidateCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\CreateCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\ExistCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\UpdatePasswordRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\ValidateCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Exceptions\CredentialWithThisIdentifyNotExists;
use SMSkin\IdentityService\Modules\Auth\Exceptions\ThisIdentifyAlreadyUsesByAnotherUser;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UserAlreadyHasCredentialWithThisIdentify;
use SMSkin\LaravelSupport\BaseModule;
use Illuminate\Validation\ValidationException;

class EmailModule extends BaseModule
{
    /**
     * @param CreateCredentialRequest $request
     * @return UserEmailCredential
     * @throws ThisIdentifyAlreadyUsesByAnotherUser
     * @throws UserAlreadyHasCredentialWithThisIdentify
     * @throws ValidationException
     */
    public function createCredential(CreateCredentialRequest $request): UserEmailCredential
    {
        $request->validate();

        return (new CCreateCredential($request))->execute()->getResult();
    }

    /**
     * @param ValidateCredentialRequest $request
     * @return bool
     * @throws ValidationException
     */
    public function validateCredential(ValidateCredentialRequest $request): bool
    {
        $request->validate();

        return (new CValidateCredential($request))->execute()->getResult();
    }

    /**
     * @param UpdatePasswordRequest $request
     * @return void
     * @throws CredentialWithThisIdentifyNotExists
     * @throws ValidationException
     */
    public function updateCredentialPassword(UpdatePasswordRequest $request): void
    {
        $request->validate();

        (new CUpdatePassword($request))->execute();
    }

    /**
     * @param ExistCredentialRequest $request
     * @return void
     * @throws ValidationException
     */
    public function deleteCredential(ExistCredentialRequest $request): void
    {
        $request->validate();

        (new CDeleteCredential($request))->execute();
    }
}
