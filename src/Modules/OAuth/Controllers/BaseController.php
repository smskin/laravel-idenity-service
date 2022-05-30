<?php

namespace SMSkin\IdentityService\Modules\OAuth\Controllers;

use SMSkin\IdentityService\Modules\Auth\Exceptions\DisabledDriver;
use SMSkin\IdentityService\Modules\Core\BaseRequest as Request;
use SMSkin\IdentityService\Modules\OAuth\Contracts\Driver;
use SMSkin\IdentityService\Modules\OAuth\Drivers\Github\GithubDriver;
use SMSkin\IdentityService\Modules\OAuth\Enums\DriverEnum;
use SMSkin\IdentityService\Modules\OAuth\Requests\BaseRequest;

abstract class BaseController extends \SMSkin\IdentityService\Modules\Core\BaseController
{
    protected BaseRequest|Request|null $request;

    protected ?string $requestClass = BaseRequest::class;

    /**
     * @return Driver
     * @throws DisabledDriver
     */
    protected function getDriver(): Driver
    {
        $driver = match ($this->request->driver) {
            DriverEnum::GITHUB => app(GithubDriver::class)
        };

        if (!in_array($this->request->driver, config('identity-service.modules.auth.oauth.drivers', []))) {
            throw new DisabledDriver();
        }
        return $driver;
    }
}
