<?php

namespace SMSkin\IdentityService\Http\Api\Resources\ScopeGroup;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;
use SMSkin\IdentityService\Models\ScopeGroup;

/**
 * @Schema
 */
class RScopeGroup extends JsonResource
{
    /**
     * @Property
     * @var int
     */
    public int $id;

    /**
     * @Property
     * @var string
     */
    public string $name;

    /**
     * @Property
     * @var string
     */
    public string $slug;

    public function __construct(ScopeGroup $resource)
    {
        parent::__construct($resource);
        $this->id = $resource->id;
        $this->name = $resource->name;
        $this->slug = $resource->slug;
    }

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug
        ];
    }
}