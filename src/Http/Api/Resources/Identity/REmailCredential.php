<?php

namespace SMSkin\IdentityService\Http\Api\Resources\Identity;

use SMSkin\IdentityService\Models\UserEmailCredential;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;
use SMSkin\IdentityServiceClient\Api\Enums\CredentialType;

/**
 * @Schema
 */
class REmailCredential extends RCredential
{
    /**
     * @Property
     * @var CredentialType
     */
    public CredentialType $type = CredentialType::EMAIL;

    /**
     * @Property
     * @var string
     */
    public string $email;

    public function __construct(UserEmailCredential $resource)
    {
        parent::__construct($resource);
        $this->email = $resource->email;
    }

    public function toArray($request): array
    {
        return array_merge(
            parent::toArray($request),
            [
                'email' => $this->email
            ]
        );
    }
}
