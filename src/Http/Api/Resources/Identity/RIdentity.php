<?php

namespace SMSkin\IdentityService\Http\Api\Resources\Identity;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @Schema
 */
class RIdentity extends JsonResource
{
    /**
     * @Property
     * @var string
     */
    public string $uuid;

    /**
     * @Property
     * @var string
     */
    public string $name;

    /**
     * @Property
     * @var string[]
     */
    public array $scopes;

    /**
     * @Property(type="string")
     * @var Carbon|null
     */
    public ?Carbon $createdAt;

    /**
     * @Property(type="string")
     * @var Carbon|null
     */
    public ?Carbon $updatedAt;

    /**
     * @param User $resource
     */
    public function __construct(Model $resource)
    {
        parent::__construct($resource);
        $this->uuid = $resource->identity_uuid;
        $this->name = $resource->name;
        $this->scopes = $this->getScopes();
        $this->createdAt = $resource->created_at;
        $this->updatedAt = $resource->updated_at;
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
            'uuid' => $this->uuid,
            'name' => $this->name,
            'scopes' => $this->scopes,
            'createdAt' => $this->createdAt?->toIso8601String(),
            'updatedAt' => $this->updatedAt?->toIso8601String(),
        ];
    }

    private function getScopes(): array
    {
        /**
         * @var User $resource
         */
        $resource = $this->resource;
        $userScopes = $resource->getScopes()->pluck('slug')->toArray();
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        $tokenScopes = auth()->getJwt()->scopes;

        $scopes = [];
        foreach ($tokenScopes as $scope) {
            if (in_array($scope, $userScopes)) {
                $scopes[] = $scope;
            }
        }
        return $scopes;
    }
}
