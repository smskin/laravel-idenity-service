<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone;

use SMSkin\IdentityService\Models\UserPhoneCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers\CAssignPhoneToUser;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers\CAssignPhoneToUserByCode;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers\CCreateCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers\CDeleteCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers\CSubmitVerifyCode;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers\CValidateVerifyCode;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\AssignPhoneToUserByCodeRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\AssignPhoneToUserRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\CreateCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\ExistCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\SendVerifyCodeRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\ValidateCredentialsRequest;
use SMSkin\IdentityService\Modules\Auth\Exceptions\InvalidPassword;
use SMSkin\IdentityService\Modules\Auth\Exceptions\ThisIdentifyAlreadyUsesByAnotherUser;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UserAlreadyHasCredentialWithThisIdentify;
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

        app(CSubmitVerifyCode::class, [
            'request' => $request
        ])->execute();
    }

    /**
     * @param ValidateCredentialsRequest $request
     * @return bool
     * @throws ValidationException
     */
    public function validateCredential(ValidateCredentialsRequest $request): bool
    {
        $request->validate();

        return app(CValidateVerifyCode::class, [
            'request' => $request
        ])->execute()->getResult();
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

        return app(CCreateCredential::class, [
            'request' => $request
        ])->execute()->getResult();
    }

    /**
     * @param AssignPhoneToUserByCodeRequest $request
     * @return UserPhoneCredential
     * @throws InvalidPassword
     * @throws ThisIdentifyAlreadyUsesByAnotherUser
     * @throws UserAlreadyHasCredentialWithThisIdentify
     * @throws ValidationException
     */
    public function assignPhoneToUserByCode(AssignPhoneToUserByCodeRequest $request): UserPhoneCredential
    {
        $request->validate();

        return app(CAssignPhoneToUserByCode::class, [
            'request' => $request
        ])->execute()->getResult();
    }

    /**
     * @param AssignPhoneToUserRequest $request
     * @return void
     * @throws ThisIdentifyAlreadyUsesByAnotherUser
     * @throws UserAlreadyHasCredentialWithThisIdentify
     * @throws ValidationException
     */
    public function assignPhoneToUser(AssignPhoneToUserRequest $request)
    {
        $request->validate();

        return app(CAssignPhoneToUser::class, [
            'request' => $request
        ])->execute()->getResult();
    }

    /**
     * @param ExistCredentialRequest $request
     * @return void
     * @throws ValidationException
     */
    public function deleteCredential(ExistCredentialRequest $request): void
    {
        $request->validate();

        app(CDeleteCredential::class, [
            'request' => $request
        ])->execute();
    }
}
