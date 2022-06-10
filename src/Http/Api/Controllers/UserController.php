<?php

namespace SMSkin\IdentityService\Http\Api\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\Items;
use OpenApi\Annotations\JsonContent;
use OpenApi\Annotations\Parameter;
use OpenApi\Annotations\Post;
use OpenApi\Annotations\Put;
use OpenApi\Annotations\Response;
use SMSkin\IdentityService\Http\Api\Requests\User\AssignScopeGroupRequest;
use SMSkin\IdentityService\Http\Api\Requests\User\CreateRequest;
use SMSkin\IdentityService\Http\Api\Requests\User\UpdateRequest;
use SMSkin\IdentityService\Http\Api\Resources\Scope\RScopeWithGroupCollection;
use SMSkin\IdentityService\Http\Api\Resources\ScopeGroup\RScopeGroupCollection;
use SMSkin\IdentityService\Http\Api\Resources\User\RUser;
use SMSkin\IdentityService\Http\Api\Resources\User\RUserCollection;
use SMSkin\IdentityService\Models\Scope;
use SMSkin\IdentityService\Models\ScopeGroup;
use SMSkin\IdentityService\Modules\User\Exceptions\ScopeAlreadyAssigned;
use SMSkin\IdentityService\Modules\User\Exceptions\ScopeGroupAlreadyAssigned;
use SMSkin\IdentityService\Modules\User\Requests\Scope\AssignScopeToUserRequest;
use SMSkin\IdentityService\Modules\User\Requests\ScopeGroup\AssignScopeGroupToUserRequest;
use SMSkin\IdentityService\Modules\User\Requests\User\CreateUserRequest;
use SMSkin\IdentityService\Modules\User\Requests\User\UpdateUserRequest;
use SMSkin\IdentityService\Modules\User\UserModule;
use SMSkin\IdentityService\Traits\ClassFromConfig;
use Illuminate\Http\Response as HttpResponse;
use function response;

class UserController extends Controller
{
    use ClassFromConfig;

    public function __construct()
    {
        $this->middleware('auth:identity-service-jwt');
    }

    /**
     * @Get(
     *     path="/identity-service/api/users",
     *     tags={"Users"},
     *     summary="Получение списка пользователей",
     *     @Parameter(
     *          name="limit",
     *          description="Количество элементов на странице",
     *          in="query",
     *          example="25",
     *          required=false
     *     ),
     *     @Parameter(
     *          name="page",
     *          description="Номер страницы",
     *          in="query",
     *          example="1",
     *          required=false
     *     ),
     *     @Response(response="200", description="Successful operation", @JsonContent(ref="#/components/schemas/RUserCollection")),
     *     @Response(response="403", description="Access denied exception"),
     *     @Response(response="422", description="Validation exception"),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getList(Request $request): JsonResponse
    {
        $this->authorize('viewAny', self::getUserModelClass());
        $users = self::getUserModel()::paginate(
            $request->input('limit', 25)
        );
        return response()->json(new RUserCollection($users));
    }

    /**
     * @Get(
     *     path="/identity-service/api/users/{userId}",
     *     tags={"Users"},
     *     summary="Получение пользователя по Identity UUID",
     *     @Parameter(
     *          name="userId",
     *          description="ID пользователя",
     *          in="query",
     *          required=true
     *     ),
     *     @Response(response="200", description="Successful operation", @JsonContent(ref="#/components/schemas/RUser")),
     *     @Response(response="403", description="Access denied exception"),
     *     @Response(response="404", description="Not found exception"),
     *     @Response(response="422", description="Validation exception"),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @param string $userId
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(string $userId): JsonResponse
    {
        $user = self::getUserModel()::whereIdentityUuid($userId)->firstOrFail();
        $this->authorize('view', $user);
        return response()->json(new RUser($user));
    }

    /**
     * @Post(
     *     path="/identity-service/api/users",
     *     tags={"Users"},
     *     summary="Создание пользователя",
     *     @Parameter(
     *          name="name",
     *          description="Имя пользователя",
     *          in="query",
     *          required=true
     *     ),
     *     @Response(response="200", description="Successful operation", @JsonContent(ref="#/components/schemas/RUser")),
     *     @Response(response="403", description="Access denied exception"),
     *     @Response(response="422", description="Validation exception"),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @param CreateRequest $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function create(CreateRequest $request): JsonResponse
    {
        $this->authorize('create', self::getUserModelClass());
        $user = (new UserModule())->create(
            (new CreateUserRequest)
                ->setName($request->input('name'))
        );
        return response()->json(new RUser($user));
    }

    /**
     * @Put(
     *     path="/identity-service/api/users/{userId}",
     *     tags={"Users"},
     *     summary="Получение списка пользователей",
     *     @Parameter(
     *          name="name",
     *          description="Имя пользователя",
     *          in="query",
     *          required=true
     *     ),
     *     @Response(response="200", description="Successful operation", @JsonContent(ref="#/components/schemas/RUser")),
     *     @Response(response="403", description="Access denied exception"),
     *     @Response(response="404", description="Not found exception"),
     *     @Response(response="422", description="Validation exception"),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @param UpdateRequest $request
     * @param string $userId
     * @return JsonResponse
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function update(UpdateRequest $request, string $userId): JsonResponse
    {
        $user = self::getUserModel()::whereIdentityUuid($userId)->firstOrFail();
        $this->authorize('update', $user);
        $r = (new UpdateUserRequest())
            ->setUser($user);
        if ($request->has('name')) {
            $r->setName($request->input('name'));
        }
        $user = (new UserModule())->update($r);
        return response()->json(new RUser($user));
    }

    /**
     * @Get(
     *     path="/identity-service/api/users/{userId}/scope-groups",
     *     tags={"Users"},
     *     summary="Получение групп скоупов по Identity UUID",
     *     @Parameter(
     *          name="userId",
     *          description="ID пользователя",
     *          in="query",
     *          required=true
     *     ),
     *     @Response(response="200", description="Successful operation", @JsonContent(type="array", @Items(ref="#/components/schemas/RScopeGroup"))),
     *     @Response(response="403", description="Access denied exception"),
     *     @Response(response="404", description="Not found exception"),
     *     @Response(response="422", description="Validation exception"),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @param string $userId
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getScopeGroups(string $userId): JsonResponse
    {
        $user = self::getUserModel()::whereIdentityUuid($userId)->firstOrFail();
        $this->authorize('view', $user);

        $groups = $user->scopeGroups()->get();
        return response()->json(new RScopeGroupCollection($groups));
    }

    /**
     * @Post(
     *     path="/identity-service/api/users/{userId}/scope-groups",
     *     tags={"Users"},
     *     summary="Добавление группы скоупов к пользователю",
     *     @Parameter(
     *          name="userId",
     *          description="ID пользователя",
     *          in="query",
     *          required=true
     *     ),
     *     @Parameter(
     *          name="group_id",
     *          description="ID группы",
     *          in="query",
     *          required=true
     *     ),
     *     @Response(response="204", description="Successful operation"),
     *     @Response(response="403", description="Access denied exception"),
     *     @Response(response="404", description="Not found exception"),
     *     @Response(response="422", description="Validation exception"),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @param AssignScopeGroupRequest $request
     * @param string $userId
     * @return HttpResponse
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function assignScopeGroup(AssignScopeGroupRequest $request, string $userId): HttpResponse
    {
        $user = self::getUserModel()::whereIdentityUuid($userId)->firstOrFail();
        $this->authorize('update', $user);

        try {
            (new UserModule())->assignScopeGroup(
                (new AssignScopeGroupToUserRequest)
                    ->setUser($user)
                    ->setGroup(ScopeGroup::findOrFail($request->input('group_id')))
            );
        } catch (ScopeGroupAlreadyAssigned) {
            throw ValidationException::withMessages([
                'group_id' => [
                    'Scope group already assigned to this user'
                ]
            ]);
        }
        return response()->noContent();
    }

    /**
     * @Get(
     *     path="/identity-service/api/users/{userId}/scopes",
     *     tags={"Users"},
     *     summary="Получение скоупов по Identity UUID",
     *     @Parameter(
     *          name="userId",
     *          description="ID пользователя",
     *          in="query",
     *          required=true
     *     ),
     *     @Response(response="200", description="Successful operation", @JsonContent(type="array", @Items(ref="#/components/schemas/RScopeWithGroup"))),
     *     @Response(response="403", description="Access denied exception"),
     *     @Response(response="404", description="Not found exception"),
     *     @Response(response="422", description="Validation exception"),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @param string $userId
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getScopes(string $userId): JsonResponse
    {
        $user = self::getUserModel()::whereIdentityUuid($userId)->firstOrFail();
        $this->authorize('view', $user);

        $scopes = $user->getScopes();
        return response()->json(new RScopeWithGroupCollection($scopes));
    }

    /**
     * @Post(
     *     path="/identity-service/api/users/{userId}/scopes",
     *     tags={"Users"},
     *     summary="Добавление скоупа к пользователю",
     *     @Parameter(
     *          name="userId",
     *          description="ID пользователя",
     *          in="query",
     *          required=true
     *     ),
     *     @Parameter(
     *          name="scope_id",
     *          description="ID скоупа",
     *          in="query",
     *          required=true
     *     ),
     *     @Response(response="204", description="Successful operation"),
     *     @Response(response="403", description="Access denied exception"),
     *     @Response(response="404", description="Not found exception"),
     *     @Response(response="422", description="Validation exception"),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @param AssignScopeGroupRequest $request
     * @param string $userId
     * @return HttpResponse
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function assignScope(AssignScopeGroupRequest $request, string $userId): HttpResponse
    {
        $user = self::getUserModel()::whereIdentityUuid($userId)->firstOrFail();
        $this->authorize('update', $user);

        try {
            (new UserModule())->assignScope(
                (new AssignScopeToUserRequest)
                    ->setUser($user)
                    ->setScope(Scope::findOrFail($request->input('scope_id')))
            );
        } catch (ScopeAlreadyAssigned) {
            throw ValidationException::withMessages([
                'scope_id' => [
                    'Scope already assigned to this user'
                ]
            ]);
        }
        return response()->noContent();
    }
}
