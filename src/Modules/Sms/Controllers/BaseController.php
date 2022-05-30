<?php

namespace SMSkin\IdentityService\Modules\Sms\Controllers;

use SMSkin\IdentityService\Modules\Sms\Contracts\Driver;
use SMSkin\IdentityService\Modules\Sms\Drivers\Log\LogDriver;
use SMSkin\IdentityService\Modules\Sms\Enums\DriverEnum;

abstract class BaseController extends \SMSkin\IdentityService\Modules\Core\BaseController
{
    protected string $method;

    /**
     * @return $this
     */
    public function execute(): self
    {
        $driver = $this->getDriver();
        $method = $this->method;
        $driver->$method($this->request);
        return $this;
    }

    /**
     * @return Driver
     */
    private function getDriver(): Driver
    {
        return match ($this->getDriverName()) {
            DriverEnum::LOG => app(LogDriver::class)
        };
    }

    private function getDriverName(): DriverEnum
    {
        return config('identity-service.modules.sms.driver');
    }
}
