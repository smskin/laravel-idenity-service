<?php

namespace SMSkin\IdentityService\Modules\Auth\Requests;

use SMSkin\IdentityService\Modules\Auth\Enums\DriverEnum;
use SMSkin\LaravelSupport\Rules\InstanceOfRule;

abstract class BaseRequest extends \SMSkin\LaravelSupport\BaseRequest
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
    public function setDriver(DriverEnum $driver): static
    {
        $this->driver = $driver;
        return $this;
    }
}
