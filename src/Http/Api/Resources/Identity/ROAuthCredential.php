<?php

namespace SMSkin\IdentityService\Http\Api\Resources\Identity;

use SMSkin\IdentityServiceClient\Api\Enums\CredentialType;
use SMSkin\IdentityService\Models\UserOauthCredential;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UnsupportedDriver;
use SMSkin\IdentityService\Modules\OAuth\Enums\DriverEnum;

class ROAuthCredential extends RCredential
{
    /**
     * @param UserOauthCredential $resource
     * @throws UnsupportedDriver
     */
    public function __construct(UserOauthCredential $resource)
    {
        parent::__construct($resource);
        $this->type = $this->getType($resource);
    }

    /**
     * @param UserOauthCredential $resource
     * @return CredentialType
     * @throws UnsupportedDriver
     */
    private function getType(UserOauthCredential $resource): CredentialType
    {
        return match ($resource->driver) {
            DriverEnum::GITHUB => CredentialType::OAUTH_GITHUB,
            default => throw new UnsupportedDriver(),
        };
    }
}
