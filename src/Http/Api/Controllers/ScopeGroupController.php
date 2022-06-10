<?php

namespace SMSkin\IdentityService\Http\Api\Controllers;

use Illuminate\Http\JsonResponse;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\Items;
use OpenApi\Annotations\JsonContent;
use OpenApi\Annotations\Parameter;
use OpenApi\Annotations\Response;
use SMSkin\IdentityService\Http\Api\Resources\Scope\RScopeCollection;
use SMSkin\IdentityService\Http\Api\Resources\ScopeGroup\RScopeGroupCollection;
use SMSkin\IdentityService\Models\ScopeGroup;
use SMSkin\IdentityService\Traits\ClassFromConfig;
use function response;

class ScopeGroupController extends Controller
{
    use ClassFromConfig;

    /**
     * @Get(
     *     path="/identity-service/api/scope-groups",
     *     tags={"Scope groups"},
     *     summary="Получение групп скоупов",
     *     @Response(response="200", description="Successful operation", @JsonContent(type="array", @Items(ref="#/components/schemas/RScopeGroup"))),
     *     @Response(response="404", description="Not found exception"),
     *     @Response(response="422", description="Validation exception"),
     * )
     *
     * @return JsonResponse
     */
    public function getList(): JsonResponse
    {
        $groups = ScopeGroup::get();
        return response()->json(new RScopeGroupCollection($groups));
    }

    /**
     * @Get(
     *     path="/identity-service/api/scope-groups/{groupId}/scopes",
     *     tags={"Scope groups"},
     *     summary="Получение скоупов группы",
     *     @Parameter(
     *          name="groupId",
     *          description="ID группы",
     *          in="path",
     *          required=true
     *     ),
     *     @Response(response="200", description="Successful operation", @JsonContent(type="array", @Items(ref="#/components/schemas/RScope"))),
     *     @Response(response="404", description="Not found exception"),
     *     @Response(response="422", description="Validation exception"),
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getScopes(int $id): JsonResponse
    {
        $group = ScopeGroup::findOrFail($id);
        return response()->json(new RScopeCollection($group->scopes()->get()));
    }
}
