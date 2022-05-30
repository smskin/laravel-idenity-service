<?php

namespace SMSkin\IdentityService\Modules\OAuth\Drivers\Support\Controllers;

use SMSkin\IdentityService\Modules\Core\BaseController;
use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\OAuth\Exceptions\DriverCredentialsNotDefined;
use SMSkin\IdentityService\Modules\OAuth\Requests\GetRedirectorRequest;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Two\AbstractProvider;

abstract class CGetRedirector extends BaseController
{
    protected GetRedirectorRequest|BaseRequest|null $request;

    protected ?string $requestClass = GetRedirectorRequest::class;

    /**
     * @return $this
     * @throws DriverCredentialsNotDefined
     */
    public function execute(): self
    {
        $this->validateCredentials();
        $this->result = $this->getSocialiteDriver()
            ->setScopes($this->request->scopes)
            ->redirect();
        return $this;
    }

    /**
     * @return void
     * @throws DriverCredentialsNotDefined
     */
    abstract protected function validateCredentials(): void;

    /**
     * @return RedirectResponse
     */
    public function getResult(): RedirectResponse
    {
        return parent::getResult();
    }

    abstract protected function getSocialiteDriver(): AbstractProvider;
}
