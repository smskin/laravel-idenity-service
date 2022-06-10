<?php

namespace SMSkin\IdentityService\Http\Api\Controllers;

use Illuminate\Http\JsonResponse;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\Items;
use OpenApi\Annotations\JsonContent;
use OpenApi\Annotations\Response;
use SMSkin\IdentityService\Http\Api\Resources\Scope\RScopeWithGroupCollection;
use SMSkin\IdentityService\Models\Scope;
use SMSkin\IdentityService\Traits\ClassFromConfig;
use function response;

class ScopeController extends Controller
{
    use ClassFromConfig;

    /**
     * @Get(
     *     path="/identity-service/api/scopes",
     *     tags={"Scope groups"},
     *     summary="Получение групп скоупов",
     *     @Response(response="200", description="Successful operation", @JsonContent(type="array", @Items(ref="#/components/schemas/RScopeWithGroup"))),
     *     @Response(response="404", description="Not found exception"),
     *     @Response(response="422", description="Validation exception"),
     * )
     *
     * @return JsonResponse
     */
    public function getList(): JsonResponse
    {
        $scopes = Scope::get();
        return response()->json(new RScopeWithGroupCollection($scopes));
    }
}