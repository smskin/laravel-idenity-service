<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Models\UserEmailCredential;
use SMSkin\IdentityService\Modules\Auth\Contracts\Driver as DriverContract;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\CreateCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\ExistCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\ValidateCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Exceptions\CredentialWithThisIdentifyNotExists;
use SMSkin\IdentityService\Modules\Auth\Exceptions\InvalidPassword;
use SMSkin\IdentityService\Modules\Auth\Exceptions\ThisIdentifyAlreadyUsesByAnotherUser;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UserAlreadyHasCredentialWithThisIdentify;
use SMSkin\IdentityService\Modules\Auth\Requests\DeleteCredentialRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\LoginRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\RegisterRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\ValidateRequest;
use SMSkin\IdentityService\Modules\User\Requests\User\CreateUserRequest;
use SMSkin\IdentityService\Modules\User\UserModule;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class Driver implements DriverContract
{
    /**
     * @param RegisterRequest $request
     * @return User
     * @throws ThisIdentifyAlreadyUsesByAnotherUser
     * @throws Throwable
     * @throws UserAlreadyHasCredentialWithThisIdentify
     * @throws ValidationException
     */
    public function register(RegisterRequest $request): Model
    {
        try {
            DB::beginTransaction();
            $user = app(UserModule::class)->create(
                (new CreateUserRequest)
                    ->setName($request->name)
            );

            app(EmailModule::class)->createCredential(
                (new CreateCredentialRequest)
                    ->setUser($user)
                    ->setEmail($request->identify)
                    ->setPassword($request->password)
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
     */
    public function validate(ValidateRequest $request): bool
    {
        return app(EmailModule::class)->validateCredential(
            (new ValidateCredentialRequest)
                ->setEmail($request->identify)
                ->setPassword($request->password)
        );
    }

    /**
     * @param LoginRequest $request
     * @return User|null
     * @throws InvalidPassword
     * @throws ValidationException
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
        $credential = UserEmailCredential::where('user_id', $request->user->id)
            ->whereEmail($request->identify)
            ->first();
        if (!$credential) {
            throw new CredentialWithThisIdentifyNotExists();
        }

        app(EmailModule::class)->deleteCredential(
            (new ExistCredentialRequest)->setCredential($credential)
        );
    }

    private function getCredential(string $identify): UserEmailCredential
    {
        return UserEmailCredential::where('email', $identify)->firstOrFail();
    }
}
