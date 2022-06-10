<?php

namespace SMSkin\IdentityService\Modules\Auth;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Models\UserEmailCredential;
use SMSkin\IdentityService\Models\UserPhoneCredential;
use SMSkin\IdentityService\Modules\Auth\Controllers\CAssignEmail;
use SMSkin\IdentityService\Modules\Auth\Controllers\CAssignPhoneToUser;
use SMSkin\IdentityService\Modules\Auth\Controllers\CDeleteCredential;
use SMSkin\IdentityService\Modules\Auth\Controllers\CLogin;
use SMSkin\IdentityService\Modules\Auth\Controllers\CRegister;
use SMSkin\IdentityService\Modules\Auth\Controllers\CValidate;
use SMSkin\IdentityService\Modules\Auth\Controllers\SendPhoneVerificationCode;
use SMSkin\IdentityService\Modules\Auth\Requests\AssignEmailToUserRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\AssignPhoneToUserRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\DeleteCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\LoginRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\RegisterRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\SendPhoneVerificationCodeRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\ValidateRequest;
use SMSkin\LaravelSupport\BaseModule;
use Illuminate\Validation\ValidationException;
use Throwable;

class AuthModule extends BaseModule
{
    /**
     * @param RegisterRequest $request
     * @return User
     * @throws Exceptions\InvalidPassword
     * @throws Exceptions\ThisIdentifyAlreadyUsesByAnotherUser
     * @throws Exceptions\UserAlreadyHasCredentialWithThisIdentify
     * @throws Exceptions\UnsupportedDriver
     * @throws Exceptions\RegistrationDisabled
     * @throws Exceptions\DisabledDriver
     * @throws ValidationException
     * @throws Throwable
     */
    public function registration(RegisterRequest $request): Model
    {
        $request->validate();

        return (new CRegister($request))->execute()->getResult();
    }

    /**
     * @param ValidateRequest $request
     * @return bool
     * @throws Exceptions\DisabledDriver
     * @throws Exceptions\UnsupportedDriver
     * @throws ValidationException
     */
    public function validate(ValidateRequest $request): bool
    {
        $request->validate();

        return (new CValidate($request))->execute()->getResult();
    }

    /**
     * @param LoginRequest $request
     * @return User
     * @throws Exceptions\DisabledDriver
     * @throws Exceptions\InvalidPassword
     * @throws Exceptions\InvalidScopes
     * @throws Exceptions\UnsupportedDriver
     * @throws ValidationException
     */
    public function login(LoginRequest $request): Model
    {
        $request->validate();

        return (new CLogin($request))->execute()->getResult();
    }

    /**
     * @param SendPhoneVerificationCodeRequest $request
     * @return void
     * @throws Exceptions\DisabledDriver
     * @throws Exceptions\VerificationAlreadyInitialized
     * @throws ValidationException
     */
    public function sendPhoneVerificationCode(SendPhoneVerificationCodeRequest $request)
    {
        $request->validate();

        return (new SendPhoneVerificationCode($request))->execute()->getResult();
    }

    /**
     * @param AssignEmailToUserRequest $request
     * @return UserEmailCredential
     * @throws Exceptions\DisabledDriver
     * @throws Exceptions\ThisIdentifyAlreadyUsesByAnotherUser
     * @throws Exceptions\UserAlreadyHasCredentialWithThisIdentify
     * @throws ValidationException
     */
    public function assignEmailToUser(AssignEmailToUserRequest $request): UserEmailCredential
    {
        $request->validate();

        return (new CAssignEmail($request))->execute()->getResult();
    }

    /**
     * @param AssignPhoneToUserRequest $request
     * @return UserPhoneCredential
     * @throws Exceptions\DisabledDriver
     * @throws Exceptions\InvalidPassword
     * @throws Exceptions\ThisIdentifyAlreadyUsesByAnotherUser
     * @throws Exceptions\UserAlreadyHasCredentialWithThisIdentify
     * @throws Exceptions\VerificationAlreadyCanceled
     * @throws ValidationException
     */
    public function assignPhoneToUserByCode(AssignPhoneToUserRequest $request): UserPhoneCredential
    {
        $request->validate();

        return (new CAssignPhoneToUser($request))->execute()->getResult();
    }

    /**
     * @param DeleteCredentialRequest $request
     * @return void
     * @throws Exceptions\CredentialWithThisIdentifyNotExists
     * @throws Exceptions\DisabledDriver
     * @throws Exceptions\UnsupportedDriver
     * @throws ValidationException
     */
    public function deleteCredential(DeleteCredentialRequest $request)
    {
        $request->validate();

        return (new CDeleteCredential($request))->execute()->getResult();
    }
}
