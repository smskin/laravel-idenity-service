<?php

namespace SMSkin\IdentityService\Http\Api\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @Schema
 */
class ROperationResult extends JsonResource
{
    /**
     * @Property
     * @var bool
     */
    public bool $result;

    public function __construct(bool $result)
    {
        parent::__construct($result);
        $this->result = $result;
    }

    public function toArray($request): array
    {
        return [
            'result' => $this->result
        ];
    }
}
