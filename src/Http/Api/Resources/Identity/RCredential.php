<?php

namespace SMSkin\IdentityService\Http\Api\Resources\Identity;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;
use SMSkin\IdentityServiceClient\Api\Enums\CredentialType;

/**
 * @Schema
 */
abstract class RCredential extends JsonResource
{
    /**
     * @Property(type="string")
     * @var CredentialType
     */
    public CredentialType $type;

    public function toArray($request): array
    {
        return [
            'type' => $this->type
        ];
    }
}
