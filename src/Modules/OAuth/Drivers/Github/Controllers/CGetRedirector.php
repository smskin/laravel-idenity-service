<?php

namespace SMSkin\IdentityService\Modules\OAuth\Drivers\Github\Controllers;

use SMSkin\IdentityService\Modules\OAuth\Drivers\Support\Controllers\CGetRedirector as BaseController;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;
use SMSkin\IdentityService\Modules\OAuth\Exceptions\DriverCredentialsNotDefined;

class CGetRedirector extends BaseController
{
    /**
     * @return void
     * @throws DriverCredentialsNotDefined
     */
    protected function validateCredentials(): void
    {
        $config = config('services.github');
        if (!$config) {
            throw new DriverCredentialsNotDefined();
        }
    }

    protected function getSocialiteDriver(): AbstractProvider
    {
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        return Socialite::driver('github')
            ->redirectUrl(route('identity-service.oauth.github.callback'));
    }
}
