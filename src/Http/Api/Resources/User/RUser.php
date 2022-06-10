<?php

namespace SMSkin\IdentityService\Http\Api\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;
use SMSkin\IdentityService\Models\Contracts\HasIdentity;

/**
 * @Schema
 */
class RUser extends JsonResource
{
    /**
     * @Property
     * @var string
     */
    public string $id;

    /**
     * @Property
     * @var string
     */
    public string $name;

    public function __construct(HasIdentity $resource)
    {
        parent::__construct($resource);
        $this->id = $resource->getIdentityUuid();
        $this->name = $resource->getName();
    }

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
