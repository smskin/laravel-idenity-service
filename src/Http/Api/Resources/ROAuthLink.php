<?php

namespace SMSkin\IdentityService\Http\Api\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @Schema
 */
class ROAuthLink extends JsonResource
{
    /**
     * @Property
     * @var string
     */
    public string $url;

    public function __construct(string $url)
    {
        parent::__construct($url);
        $this->url = $url;
    }

    public function toArray($request): array
    {
        return [
            'url' => $this->url
        ];
    }
}
