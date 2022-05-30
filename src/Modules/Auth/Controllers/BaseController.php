<?php

namespace SMSkin\IdentityService\Modules\Auth\Controllers;

use SMSkin\IdentityService\Modules\Auth\Contracts\Driver as DriverContract;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Driver as EmailDriver;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Driver as PhoneDriver;
use SMSkin\IdentityService\Modules\Auth\Enums\DriverEnum;
use SMSkin\IdentityService\Modules\Auth\Exceptions\DisabledDriver;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UnsupportedDriver;
use SMSkin\IdentityService\Modules\Core\BaseRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\BaseRequest as AuthBaseRequest;

abstract class BaseController extends \SMSkin\IdentityService\Modules\Core\BaseController
{
    protected AuthBaseRequest|BaseRequest|null $request;

    protected ?string $requestClass = AuthBaseRequest::class;

    /**
     * @return DriverContract
     * @throws DisabledDriver
     * @throws UnsupportedDriver
     */
    protected function getDriver(): DriverContract
    {
        $driver = match ($this->request->driver) {
            DriverEnum::EMAIL => $this->getEmailDriver(),
            DriverEnum::PHONE => $this->getPhoneDriver(),
            default => throw new UnsupportedDriver(),
        };

        if (!in_array($this->request->driver, config('identity-service.modules.auth.auth.drivers', []))) {
            throw new DisabledDriver();
        }
        return $driver;
    }

    private function getEmailDriver(): EmailDriver
    {
        return app(EmailDriver::class);
    }

    private function getPhoneDriver(): PhoneDriver
    {
        return app(PhoneDriver::class);
    }
}
