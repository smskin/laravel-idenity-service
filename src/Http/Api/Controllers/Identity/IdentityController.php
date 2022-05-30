<?php

namespace SMSkin\IdentityService\Http\Api\Controllers\Identity;

use SMSkin\IdentityService\Http\Api\Controllers\Controller;
use SMSkin\IdentityService\Http\Api\Resources\Identity\RIdentity;
use SMSkin\IdentityService\Http\Api\Resources\Identity\RScopeCollection;
use SMSkin\IdentityService\Http\Api\Resources\ROperationResult;
use SMSkin\IdentityService\Modules\User\Requests\User\UpdateUserRequest;
use SMSkin\IdentityService\Modules\User\UserModule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\JsonContent;
use OpenApi\Annotations\Parameter;
use OpenApi\Annotations\Put;
use OpenApi\Annotations\Items;
use function auth;
use function response;

class IdentityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:identity-service-jwt');
    }

    /**
     * @Get(
     *     path="/identity-service/api/identity",
     *     tags={"Identity"},
     *     summary="Получение данных пользователя",
     *     @\OpenApi\Annotations\Response(response="200", description="Successful operation", @JsonContent(ref="#/components/schemas/RIdentity")),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json(new RIdentity($user));
    }

    /**
     * @Get(
     *     path="/identity-service/api/identity/scopes",
     *     tags={"Identity"},
     *     summary="Получение данных пользователя",
     *     @\OpenApi\Annotations\Response(response="200", description="Successful operation", @JsonContent(type="array", @Items(ref="#/components/schemas/RScope"))),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getScopes(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json((new RScopeCollection($user->getScopes())));
    }

    /**
     * @Put(
     *     path="/identity-service/api/identity",
     *     tags={"Identity"},
     *     summary="Обновление данных пользователя",
     *     @Parameter(
     *          name="name",
     *          description="Имя",
     *          in="query",
     *          required=false
     *     ),
     *     @\OpenApi\Annotations\Response(response="200", description="Successful operation", @JsonContent(ref="#/components/schemas/RIdentity")),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request): JsonResponse
    {
        $user = $request->user();
        $r = (new UpdateUserRequest)
            ->setUser($user);
        if ($request->has('name')) {
            $r->setName($request->input('name'));
        }

        app(UserModule::class)->update($r);
        return response()->json(new RIdentity($user));
    }

    /**
     * @Get(
     *     path="/identity-service/api/identity/logout",
     *     tags={"Identity"},
     *     summary="Блокировка текущего Access Token",
     *     @\OpenApi\Annotations\Response(response="204", description="Successful operation"),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(new ROperationResult(true));
    }
}
