<?php

namespace SMSkin\IdentityService\Modules\OAuth;

use SMSkin\IdentityService\Modules\Auth\Exceptions\DisabledDriver;
use SMSkin\IdentityService\Modules\Auth\Exceptions\RegistrationDisabled;
use SMSkin\LaravelSupport\BaseModule;
use SMSkin\IdentityService\Modules\OAuth\Controllers\CGetRedirector;
use SMSkin\IdentityService\Modules\OAuth\Controllers\CProcessCallback;
use SMSkin\IdentityService\Modules\OAuth\Exceptions\DriverCredentialsNotDefined;
use SMSkin\IdentityService\Modules\OAuth\Requests\GetRedirectorRequest;
use SMSkin\IdentityService\Modules\OAuth\Requests\ProcessCallbackRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use MiladRahimi\Jwt\Exceptions\JsonEncodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;

class OAuthModule extends BaseModule
{
    /**
     * @param GetRedirectorRequest $request
     * @return RedirectResponse
     * @throws DisabledDriver
     * @throws Exceptions\InvalidSignature
     * @throws ValidationException
     * @throws DriverCredentialsNotDefined
     */
    public function getRedirector(GetRedirectorRequest $request): RedirectResponse
    {
        $request->validate();

        return app(CGetRedirector::class, [
            'request' => $request
        ])->execute()->getResult();
    }

    /**
     * @param ProcessCallbackRequest $request
     * @return RedirectResponse
     * @throws DisabledDriver
     * @throws Exceptions\RemoteIdAlreadyAssignedToAnotherUser
     * @throws JsonEncodingException
     * @throws RegistrationDisabled
     * @throws SigningException
     * @throws ValidationException
     */
    public function processCallback(ProcessCallbackRequest $request): RedirectResponse
    {
        $request->validate();

        return app(CProcessCallback::class, [
            'request' => $request
        ])->execute()->getResult();
    }
}
