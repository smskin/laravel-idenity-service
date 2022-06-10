<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone;

use SMSkin\IdentityService\Models\UserPhoneCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers\CAssignPhoneToUserByCode;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers\CCreateCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers\CDeleteCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers\CSubmitVerifyCode;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers\CValidateVerifyCode;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\AssignPhoneToUserByCodeRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\CreateCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\ExistCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\SendVerifyCodeRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\ValidateCredentialsRequest;
use SMSkin\IdentityService\Modules\Auth\Exceptions\InvalidPassword;
use SMSkin\IdentityService\Modules\Auth\Exceptions\ThisIdentifyAlreadyUsesByAnotherUser;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UserAlreadyHasCredentialWithThisIdentify;
use SMSkin\IdentityService\Modules\Auth\Exceptions\VerificationAlreadyCanceled;
use SMSkin\IdentityService\Modules\Auth\Exceptions\VerificationAlreadyInitialized;
use SMSkin\LaravelSupport\BaseModule;
use Illuminate\Validation\ValidationException;

class PhoneModule extends BaseModule
{
    /**
     * @param SendVerifyCodeRequest $request
     * @return void
     * @throws VerificationAlreadyInitialized
     * @throws ValidationException
     */
    public function sendVerifyCode(SendVerifyCodeRequest $request): void
    {
        $request->validate();

        (new CSubmitVerifyCode($request))->execute();
    }

    /**
     * @param ValidateCredentialsRequest $request
     * @return bool
     * @throws ValidationException
     * @throws VerificationAlreadyCanceled
     */
    public function validateCredential(ValidateCredentialsRequest $request): bool
    {
        $request->validate();

        return (new CValidateVerifyCode($request))->execute()->getResult();
    }

    /**
     * @param CreateCredentialRequest $request
     * @return UserPhoneCredential
     * @throws ThisIdentifyAlreadyUsesByAnotherUser
     * @throws UserAlreadyHasCredentialWithThisIdentify
     * @throws ValidationException
     */
    public function createCredential(CreateCredentialRequest $request): UserPhoneCredential
    {
        $request->validate();

        return (new CCreateCredential($request))->execute()->getResult();
    }

    /**
     * @param AssignPhoneToUserByCodeRequest $request
     * @return UserPhoneCredential
     * @throws InvalidPassword
     * @throws ThisIdentifyAlreadyUsesByAnotherUser
     * @throws UserAlreadyHasCredentialWithThisIdentify
     * @throws ValidationException
     * @throws VerificationAlreadyCanceled
     */
    public function assignPhoneToUserByCode(AssignPhoneToUserByCodeRequest $request): UserPhoneCredential
    {
        $request->validate();

        return (new CAssignPhoneToUserByCode($request))->execute()->getResult();
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
