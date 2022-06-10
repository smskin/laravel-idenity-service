<?php

namespace SMSkin\IdentityService\Http\Api\Resources\Scope;

use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;
use SMSkin\IdentityService\Http\Api\Resources\ScopeGroup\RScopeGroup;
use SMSkin\IdentityService\Models\Scope;

/**
 * @Schema
 */
class RScopeWithGroup extends ResourceCollection
{
    /**
     * @Property
     * @var RScopeGroup
     */
    public RScopeGroup $group;

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
        $this->group = new RScopeGroup($resource->getGroup());
        $this->id = $resource->id;
        $this->name = $resource->name;
        $this->slug = $resource->slug;
    }

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'group' => $this->group->toArray($request),
            'name' => $this->name,
            'slug' => $this->slug
        ];
    }
}