<?php

namespace SMSkin\IdentityService\Http\Api\Resources\Identity;

use SMSkin\IdentityService\Models\UserPhoneCredential;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;
use SMSkin\IdentityServiceClient\Api\Enums\CredentialType;

/**
 * @Schema
 */
class RPhoneCredential extends RCredential
{
    /**
     * @Property
     * @var CredentialType
     */
    public CredentialType $type = CredentialType::PHONE;

    /**
     * @Property
     * @var string
     */
    public string $phone;

    public function __construct(UserPhoneCredential $resource)
    {
        parent::__construct($resource);
        $this->phone = $resource->phone;
    }

    public function toArray($request): array
    {
        return array_merge(
            parent::toArray($request),
            [
                'phone' => $this->phone
            ]
        );
    }
}
