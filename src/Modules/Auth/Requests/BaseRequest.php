<?php

namespace SMSkin\IdentityService\Modules\Auth\Requests;

use SMSkin\IdentityService\Modules\Auth\Enums\DriverEnum;
use SMSkin\IdentityService\Modules\Core\Rules\InstanceOfRule;

abstract class BaseRequest extends \SMSkin\IdentityService\Modules\Core\BaseRequest
{
    public DriverEnum $driver;

    public function rules(): array
    {
        return [
            'driver' => [
                'required',
                new InstanceOfRule(DriverEnum::class)
            ]
        ];
    }

    /**
     * @param DriverEnum $driver
     * @return self
     */
    public function setDriver(DriverEnum $driver): self
    {
        $this->driver = $driver;
        return $this;
    }
}