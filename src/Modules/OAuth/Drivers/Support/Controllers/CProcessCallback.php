<?php

namespace SMSkin\IdentityService\Modules\OAuth\Drivers\Support\Controllers;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Models\UserOauthCredential;
use SMSkin\IdentityService\Modules\Auth\Exceptions\RegistrationDisabled;
use SMSkin\IdentityService\Modules\Core\BaseController;
use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\OAuth\Controllers\CCreateCredential;
use SMSkin\IdentityService\Modules\OAuth\Enums\DriverEnum;
use SMSkin\IdentityService\Modules\OAuth\Exceptions\CredentialWithThisRemoteIdAlreadyExists;
use SMSkin\IdentityService\Modules\OAuth\Exceptions\RemoteIdAlreadyAssignedToAnotherUser;
use SMSkin\IdentityService\Modules\OAuth\Requests\CreateCredentialRequest;
use SMSkin\IdentityService\Modules\OAuth\Requests\ProcessCallbackRequest;
use SMSkin\IdentityService\Modules\User\Requests\User\CreateUserRequest;
use SMSkin\IdentityService\Modules\User\UserModule;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\User as OauthUser;

abstract class CProcessCallback extends BaseController
{
    protected ProcessCallbackRequest|BaseRequest|null $request;

    protected ?string $requestClass = ProcessCallbackRequest::class;

    abstract protected function getOauthUser(): OauthUser;

    abstract protected function getSocialiteDriver(): AbstractProvider;

    /**
     * @param OauthUser $oauthUser
     * @return UserOauthCredential
     * @throws RegistrationDisabled
     * @throws RemoteIdAlreadyAssignedToAnotherUser
     * @throws ValidationException
     */
    protected function getCredential(OauthUser $oauthUser): UserOauthCredential
    {
        $credential = $this->getCredentialByRemoteId($oauthUser->id);
        if ($credential) {
            if ($this->request->user && $this->request->user->id !== $credential->user_id) {
                throw new RemoteIdAlreadyAssignedToAnotherUser();
            }
            return $credential;
        }

        $user = $this->request->user;
        if (!$user) {
            $user = $this->createUser($oauthUser);
        }
        return $this->createCredential($user, $oauthUser);
    }

    /**
     * @param OauthUser $oauthUser
     * @return User
     * @throws RegistrationDisabled
     * @throws ValidationException
     */
    private function createUser(OauthUser $oauthUser): Model
    {
        if (!config('identity-service.modules.auth.registration.active', false))
        {
            throw new RegistrationDisabled();
        }

        return app(UserModule::class)->create(
            (new CreateUserRequest)
                ->setName($oauthUser->name)
        );
    }

    /**
     * @param User $user
     * @param OauthUser $oauthUser
     * @return UserOauthCredential
     */
    private function createCredential(Model $user, OauthUser $oauthUser): UserOAuthCredential
    {
        $credential = null;
        try {
            $credential = app(CCreateCredential::class, [
                'request' => (new CreateCredentialRequest)
                    ->setDriver(DriverEnum::GITHUB)
                    ->setUser($user)
                    ->setRemoteId($oauthUser->id)
            ])->execute()->getResult();
        } catch (CredentialWithThisRemoteIdAlreadyExists) {
            // not possible
        }
        return $credential;
    }

    private function getCredentialByRemoteId(string $id): ?UserOAuthCredential
    {
        return UserOAuthCredential::where('remote_id', $id)->first();
    }
}
