<?php

namespace SMSkin\IdentityService\Http\Api\Resources\Auth;

use SMSkin\IdentityService\Modules\Jwt\Models\Token;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @Schema
 */
class RToken extends JsonResource
{
    /**
     * @Property
     * @var string
     */
    public string $value;

    /**
     * @Property
     * @var int
     */
    public int $expiresIn;

    /**
     * @Property(type="string")
     * @var Carbon
     */
    public Carbon $expireAt;

    public function __construct(Token $resource)
    {
        parent::__construct($resource);
        $this->value = $resource->value;
        $this->expiresIn = $resource->expiresIn;
        $this->expireAt = $resource->expireAt;
    }

    public function toArray($request): array
    {
        return [
            'value' => $this->value,
            'expiresIn' => $this->expiresIn,
            'expireAt' => $this->expireAt->toIso8601String()
        ];
    }
}
