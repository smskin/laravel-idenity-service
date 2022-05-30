<?php

namespace SMSkin\IdentityService\Http\Api\Resources\Identity;

use SMSkin\IdentityService\Models\Scope;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @Schema
 */
class RScope extends JsonResource
{
    /**
     * @Property
     * @var string
     */
    public string $name;

    /**
     * @Property
     * @var string
     */
    public string $value;

    public function __construct(Scope $resource)
    {
        parent::__construct($resource);
        $this->name = $resource->name;
        $this->value = $resource->slug;
    }

    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value
        ];
    }
}
