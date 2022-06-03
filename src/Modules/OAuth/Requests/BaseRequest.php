<?php

namespace SMSkin\IdentityService\Modules\OAuth\Requests;

use SMSkin\LaravelSupport\Rules\InstanceOfRule;
use SMSkin\IdentityService\Modules\OAuth\Enums\DriverEnum;

class BaseRequest extends \SMSkin\LaravelSupport\BaseRequest
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
