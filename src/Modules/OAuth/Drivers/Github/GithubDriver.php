<?php

namespace SMSkin\IdentityService\Modules\OAuth\Drivers\Github;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Modules\Auth\Exceptions\RegistrationDisabled;
use SMSkin\LaravelSupport\BaseModule;
use SMSkin\IdentityService\Modules\OAuth\Contracts\Driver;
use SMSkin\IdentityService\Modules\OAuth\Drivers\Github\Controllers\CGetRedirector;
use SMSkin\IdentityService\Modules\OAuth\Drivers\Github\Controllers\CProcessCallback;
use SMSkin\IdentityService\Modules\OAuth\Exceptions\DriverCredentialsNotDefined;
use SMSkin\IdentityService\Modules\OAuth\Exceptions\RemoteIdAlreadyAssignedToAnotherUser;
use SMSkin\IdentityService\Modules\OAuth\Requests\GetRedirectorRequest;
use SMSkin\IdentityService\Modules\OAuth\Requests\ProcessCallbackRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class GithubDriver extends BaseModule implements Driver
{
    /**
     * @param GetRedirectorRequest $request
     * @return RedirectResponse
     * @throws ValidationException
     * @throws DriverCredentialsNotDefined
     */
    public function getRedirector(GetRedirectorRequest $request): RedirectResponse
    {
        $request->validate();

        return (new CGetRedirector($request))->execute()->getResult();
    }

    /**
     * @param ProcessCallbackRequest $request
     * @return User
     * @throws RegistrationDisabled
     * @throws RemoteIdAlreadyAssignedToAnotherUser
     * @throws ValidationException
     */
    public function processCallback(ProcessCallbackRequest $request): Model
    {
        $request->validate();

        return (new CProcessCallback($request))->execute()->getResult();
    }
}
