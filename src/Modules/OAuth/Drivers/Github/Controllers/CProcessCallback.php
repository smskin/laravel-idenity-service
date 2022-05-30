<?php

namespace SMSkin\IdentityService\Modules\OAuth\Drivers\Github\Controllers;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Modules\Auth\Exceptions\RegistrationDisabled;
use SMSkin\IdentityService\Modules\OAuth\Drivers\Support\Controllers\CProcessCallback as BaseController;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Modules\OAuth\Exceptions\RemoteIdAlreadyAssignedToAnotherUser;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\User as OauthUser;

class CProcessCallback extends BaseController
{
    /**
     * @return $this
     * @throws RegistrationDisabled
     * @throws RemoteIdAlreadyAssignedToAnotherUser
     * @throws ValidationException
     */
    public function execute(): self
    {
        $oauthUser = $this->getOauthUser();
        $credential = $this->getCredential($oauthUser);
        $this->result = $credential->user;
        return $this;
    }

    /**
     * @return User
     */
    public function getResult(): Model
    {
        return parent::getResult();
    }

    protected function getOauthUser(): OauthUser
    {
        return $this->getSocialiteDriver()
            ->user();
    }

    protected function getSocialiteDriver(): AbstractProvider
    {
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        return Socialite::driver('github')
            ->redirectUrl(route('identity-service.oauth.github.callback'));
    }
}
