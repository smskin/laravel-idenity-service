<?php

namespace SMSkin\IdentityService\Modules\Auth\Contracts;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Modules\Auth\Exceptions\CredentialWithThisIdentifyNotExists;
use SMSkin\IdentityService\Modules\Auth\Exceptions\InvalidPassword;
use SMSkin\IdentityService\Modules\Auth\Exceptions\ThisIdentifyAlreadyUsesByAnotherUser;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UserAlreadyHasCredentialWithThisIdentify;
use SMSkin\IdentityService\Modules\Auth\Requests\DeleteCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\LoginRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\RegisterRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\ValidateRequest;
use Illuminate\Validation\ValidationException;
use Throwable;

interface Driver
{
    /**
     * @param RegisterRequest $request
     * @return User
     * @throws ThisIdentifyAlreadyUsesByAnotherUser
     * @throws Throwable
     * @throws UserAlreadyHasCredentialWithThisIdentify
     * @throws ValidationException
     */
    public function register(RegisterRequest $request): Model;

    /**
     * @param ValidateRequest $request
     * @return bool
     * @throws ValidationException
     */
    public function validate(ValidateRequest $request): bool;

    /**
     * @param LoginRequest $request
     * @return User|null
     * @throws InvalidPassword
     * @throws ValidationException
     */
    public function login(LoginRequest $request): ?Model;

    /**
     * @param DeleteCredentialRequest $request
     * @return void
     * @throws CredentialWithThisIdentifyNotExists
     * @throws ValidationException
     */
    public function deleteCredential(DeleteCredentialRequest $request): void;
}
