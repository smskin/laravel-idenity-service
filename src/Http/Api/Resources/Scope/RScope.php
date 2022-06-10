<?php

namespace SMSkin\IdentityService\Http\Api\Resources\Scope;

use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;
use SMSkin\IdentityService\Models\Scope;

/**
 * @Schema
 */
class RScope extends ResourceCollection
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

    public function __construct(Scope $resource)
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