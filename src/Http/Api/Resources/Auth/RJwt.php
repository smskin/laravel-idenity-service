<?php

namespace SMSkin\IdentityService\Http\Api\Resources\Auth;

use SMSkin\IdentityService\Modules\Jwt\Models\Jwt;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @Schema
 */
class RJwt extends JsonResource
{
    /**
     * @Property
     * @var RToken
     */
    public RToken $accessToken;

    /**
     * @Property
     * @var RToken
     */
    public RToken $refreshToken;

    public function __construct(Jwt $resource)
    {
        parent::__construct($resource);
        $this->accessToken = new RToken($resource->accessToken);
        $this->refreshToken = new RToken($resource->refreshToken);
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'accessToken' => $this->accessToken,
            'refreshToken' => $this->refreshToken
        ];
    }
}
