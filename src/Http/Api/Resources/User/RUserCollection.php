<?php

namespace SMSkin\IdentityService\Http\Api\Resources\User;

use Illuminate\Support\Collection;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;
use SMSkin\LaravelSupport\Resources\RPaginatedResourceCollection;

/**
 * @Schema
 */
class RUserCollection extends RPaginatedResourceCollection
{
    /**
     * @var Collection<RUser>
     * @Property(type="array", @OA\Items(ref="#/components/schemas/RUser"))
     */
    public Collection $items;
}