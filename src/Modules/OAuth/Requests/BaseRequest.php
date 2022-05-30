<?php

namespace SMSkin\IdentityService\Modules\OAuth\Requests;

use SMSkin\IdentityService\Modules\Core\Rules\InstanceOfRule;
use SMSkin\IdentityService\Modules\OAuth\Enums\DriverEnum;

class BaseRequest extends \SMSkin\IdentityService\Modules\Core\BaseRequest
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
