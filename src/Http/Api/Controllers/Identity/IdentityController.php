<?php

namespace SMSkin\IdentityService\Http\Api\Controllers\Identity;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use MiladRahimi\Jwt\Exceptions\JsonEncodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\Items;
use OpenApi\Annotations\JsonContent;
use OpenApi\Annotations\Parameter;
use OpenApi\Annotations\Post;
use OpenApi\Annotations\Put;
use SMSkin\IdentityService\Http\Api\Controllers\Controller;
use SMSkin\IdentityService\Http\Api\Requests\Identity\ImpersonateRequest;
use SMSkin\IdentityService\Http\Api\Resources\Auth\RJwt;
use SMSkin\IdentityService\Http\Api\Resources\Identity\RIdentity;
use SMSkin\IdentityService\Http\Api\Resources\Identity\RIdentityScopeCollection;
use SMSkin\IdentityService\Http\Api\Resources\ROperationResult;
use SMSkin\IdentityService\Modules\Jwt\JwtModule;
use SMSkin\IdentityService\Modules\Jwt\Requests\GenerateAccessTokenByUserRequest;
use SMSkin\IdentityService\Modules\User\Requests\User\UpdateUserRequest;
use SMSkin\IdentityService\Modules\User\UserModule;
use SMSkin\IdentityService\Traits\ClassFromConfig;
use function auth;
use function response;

class IdentityController extends Controller
{
    use ClassFromConfig;

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
     *     @\OpenApi\Annotations\Response(response="200", description="Successful operation", @JsonContent(type="array", @Items(ref="#/components/schemas/RIdentityScope"))),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getScopes(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json((new RIdentityScopeCollection($user->getScopes())));
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

        (new UserModule)->update($r);
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

    /**
     * @Post(
     *     path="/identity-service/api/identity/impersonate",
     *     tags={"Identity"},
     *     summary="Получение JWT по UUID пользователя",
     *     @Parameter(
     *          name="uuid",
     *          description="UUID пользователя",
     *          in="query",
     *          required=true
     *     ),
     *     @\OpenApi\Annotations\Response(response="200", description="Successful operation", @JsonContent(ref="#/components/schemas/RJwt")),
     *     @\OpenApi\Annotations\Response(response="403", description="Access denied exception"),
     *     @\OpenApi\Annotations\Response(response="422", description="Validation exception"),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @param ImpersonateRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws ValidationException
     * @throws JsonEncodingException
     * @throws SigningException
     */
    public function impersonate(ImpersonateRequest $request): JsonResponse
    {
        $uuid = $request->input('uuid');
        $user = self::getUserModel()::where('identity_uuid', $uuid)->firstOrFail();
        $this->authorize('impersonate', $user);

        $jwt = (new JwtModule)->generateAccessTokenByUser(
            (new GenerateAccessTokenByUserRequest)
                ->setUser($user)
                ->setScopes($user->getScopes()->pluck('slug')->toArray())
        );
        return response()->json(new RJwt($jwt));
    }
}
