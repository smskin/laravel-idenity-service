<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Models\UserPhoneCredential;
use SMSkin\IdentityService\Modules\Auth\Contracts\Driver as DriverContract;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\CreateCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\ExistCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Requests\ValidateCredentialsRequest;
use SMSkin\IdentityService\Modules\Auth\Exceptions\CredentialWithThisIdentifyNotExists;
use SMSkin\IdentityService\Modules\Auth\Exceptions\InvalidPassword;
use SMSkin\IdentityService\Modules\Auth\Exceptions\ThisIdentifyAlreadyUsesByAnotherUser;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UserAlreadyHasCredentialWithThisIdentify;
use SMSkin\IdentityService\Modules\Auth\Exceptions\VerificationAlreadyCanceled;
use SMSkin\IdentityService\Modules\Auth\Requests\DeleteCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\LoginRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\RegisterRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\ValidateRequest;
use SMSkin\IdentityService\Modules\User\Requests\User\CreateUserRequest;
use SMSkin\IdentityService\Modules\User\UserModule;
use Illuminate\Validation\ValidationException;
use Throwable;

class Driver implements DriverContract
{
    /**
     * @param RegisterRequest $request
     * @return User
     * @throws InvalidPassword
     * @throws ThisIdentifyAlreadyUsesByAnotherUser
     * @throws Throwable
     * @throws UserAlreadyHasCredentialWithThisIdentify
     * @throws ValidationException
     */
    public function register(RegisterRequest $request): Model
    {
        $result = (new PhoneModule)->validateCredential(
            (new ValidateCredentialsRequest)
                ->setPhone($request->identify)
                ->setCode($request->password)
        );

        if (!$result) {
            throw new InvalidPassword();
        }

        try {
            DB::beginTransaction();
            $user = (new UserModule)->create(
                (new CreateUserRequest)
                    ->setName($request->name)
            );

            (new PhoneModule)->createCredential(
                (new CreateCredentialRequest)
                    ->setUser($user)
                    ->setPhone($request->identify)
            );
            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $user;
    }

    /**
     * @param ValidateRequest $request
     * @return bool
     * @throws ValidationException
     * @throws VerificationAlreadyCanceled
     */
    public function validate(ValidateRequest $request): bool
    {
        return (new PhoneModule)->validateCredential(
            (new ValidateCredentialsRequest)
                ->setPhone($request->identify)
                ->setCode($request->password)
        );
    }

    /**
     * @param LoginRequest $request
     * @return User|null
     * @throws InvalidPassword
     * @throws ValidationException
     * @throws VerificationAlreadyCanceled
     */
    public function login(LoginRequest $request): ?Model
    {
        $result = $this->validate(
            (new ValidateRequest)
                ->setDriver($request->driver)
                ->setIdentify($request->identify)
                ->setPassword($request->password)
        );

        if (!$result) {
            throw new InvalidPassword();
        }

        $credential = $this->getCredential($request->identify);
        return $credential->user;
    }

    /**
     * @param DeleteCredentialRequest $request
     * @return void
     * @throws CredentialWithThisIdentifyNotExists
     * @throws ValidationException
     */
    public function deleteCredential(DeleteCredentialRequest $request): void
    {
        $credential = UserPhoneCredential::where('user_id', $request->user->id)
            ->wherePhone($request->identify)
            ->first();
        if (!$credential) {
            throw new CredentialWithThisIdentifyNotExists();
        }

        (new PhoneModule)->deleteCredential(
            (new ExistCredentialRequest)->setCredential($credential)
        );
    }

    private function getCredential(string $identify): UserPhoneCredential
    {
        return UserPhoneCredential::where('phone', $identify)->firstOrFail();
    }
}
