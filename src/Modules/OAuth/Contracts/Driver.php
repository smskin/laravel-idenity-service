<?php

namespace SMSkin\IdentityService\Modules\OAuth\Contracts;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Modules\Auth\Exceptions\RegistrationDisabled;
use SMSkin\IdentityService\Modules\OAuth\Exceptions\DriverCredentialsNotDefined;
use SMSkin\IdentityService\Modules\OAuth\Exceptions\RemoteIdAlreadyAssignedToAnotherUser;
use SMSkin\IdentityService\Modules\OAuth\Requests\GetRedirectorRequest;
use SMSkin\IdentityService\Modules\OAuth\Requests\ProcessCallbackRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

interface Driver
{
    /**
     * @param GetRedirectorRequest $request
     * @return RedirectResponse
     * @throws ValidationException
     * @throws DriverCredentialsNotDefined
     */
    public function getRedirector(GetRedirectorRequest $request): RedirectResponse;

    /**
     * @param ProcessCallbackRequest $request
     * @return User
     * @throws RegistrationDisabled
     * @throws RemoteIdAlreadyAssignedToAnotherUser
     * @throws ValidationException
     */
    public function processCallback(ProcessCallbackRequest $request): Model;
}
