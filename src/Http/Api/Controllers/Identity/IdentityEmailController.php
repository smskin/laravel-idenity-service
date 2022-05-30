<?php

namespace SMSkin\IdentityService\Http\Api\Controllers\Identity;

use SMSkin\IdentityService\Http\Api\Controllers\Controller;
use SMSkin\IdentityService\Http\Api\Requests\Identity\Email\AssignEmailRequest;
use SMSkin\IdentityService\Http\Api\Requests\Identity\Email\DeleteEmailRequest;
use SMSkin\IdentityService\Http\Api\Requests\Identity\Email\UpdatePasswordRequest;
use SMSkin\IdentityService\Http\Api\Resources\ROperationResult;
use SMSkin\IdentityService\Modules\Auth\AuthModule;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\EmailModule;
use SMSkin\IdentityService\Modules\Auth\Enums\DriverEnum;
use SMSkin\IdentityService\Modules\Auth\Exceptions\CredentialWithThisIdentifyNotExists;
use SMSkin\IdentityService\Modules\Auth\Exceptions\DisabledDriver;
use SMSkin\IdentityService\Modules\Auth\Exceptions\ThisIdentifyAlreadyUsesByAnotherUser;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UnsupportedDriver;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UserAlreadyHasCredentialWithThisIdentify;
use SMSkin\IdentityService\Modules\Auth\Requests\AssignEmailToUserRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\DeleteCredentialRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations\Delete;
use OpenApi\Annotations\JsonContent;
use OpenApi\Annotations\Parameter;
use OpenApi\Annotations\Post;
use OpenApi\Annotations\Put;
use function app;
use function response;

class IdentityEmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:identity-service-jwt');
    }

    /**
     * @Post(
     *     path="/identity-service/api/identity/email",
     *     tags={"Identity"},
     *     summary="Добавление почтового адреса к учетной записи пользователя",
     *     @Parameter(
     *          name="email",
     *          description="Адрес электронной почты",
     *          in="query",
     *          required=true
     *     ),
     *     @Parameter(
     *          name="password",
     *          description="Пароль",
     *          in="query",
     *          required=true
     *     ),
     *     @\OpenApi\Annotations\Response(response="200", description="Successful operation", @JsonContent(ref="#/components/schemas/ROperationResult")),
     *     @\OpenApi\Annotations\Response(response="422", description="Validation exception"),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @param AssignEmailRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function assign(AssignEmailRequest $request): JsonResponse
    {
        $user = $request->user();

        try {
            app(AuthModule::class)->assignEmailToUser(
                (new AssignEmailToUserRequest)
                    ->setUser($user)
                    ->setEmail($request->input('email'))
                    ->setPassword($request->input('password'))
            );
        } catch (DisabledDriver) {
            throw ValidationException::withMessages(['email' => ['Email driver is disabled']]);
        } catch (ThisIdentifyAlreadyUsesByAnotherUser) {
            throw ValidationException::withMessages(['email' => ['Phone already uses by another user']]);
        } catch (UserAlreadyHasCredentialWithThisIdentify) {
            throw ValidationException::withMessages(['email' => ['You already has account with this phone']]);
        }

        return response()->json(new ROperationResult(true));
    }

    /**
     * @Put(
     *     path="/identity-service/api/identity/email",
     *     tags={"Identity"},
     *     summary="Обновление пароля учетной записи пользователя",
     *     @Parameter(
     *          name="email",
     *          description="Адрес электронной почты",
     *          in="query",
     *          required=true
     *     ),
     *     @Parameter(
     *          name="password",
     *          description="Пароль",
     *          in="query",
     *          required=true
     *     ),
     *     @\OpenApi\Annotations\Response(response="200", description="Successful operation", @JsonContent(ref="#/components/schemas/ROperationResult")),
     *     @\OpenApi\Annotations\Response(response="422", description="Validation exception"),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @param UpdatePasswordRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $user = $request->user();

        try {
            app(EmailModule::class)->updateCredentialPassword(
                (new \SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\UpdatePasswordRequest)
                    ->setUser($user)
                    ->setEmail($request->input('email'))
                    ->setPassword($request->input('password'))
            );
        } catch (CredentialWithThisIdentifyNotExists) {
            throw ValidationException::withMessages(['email' => ["This user hasn't credential with this email"]]);
        }

        return response()->json(new ROperationResult(true));
    }

    /**
     * @Delete(
     *     path="/identity-service/api/identity/email",
     *     tags={"Identity"},
     *     summary="Удаление почтового адреса к учетной записи пользователя",
     *     @Parameter(
     *          name="email",
     *          description="Адрес электронной почты",
     *          in="query",
     *          required=true
     *     ),
     *     @\OpenApi\Annotations\Response(response="200", description="Successful operation", @JsonContent(ref="#/components/schemas/ROperationResult")),
     *     @\OpenApi\Annotations\Response(response="422", description="Validation exception"),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @param DeleteEmailRequest $request
     * @return JsonResponse
     * @throws UnsupportedDriver
     * @throws ValidationException
     */
    public function deleteEmail(DeleteEmailRequest $request): JsonResponse
    {
        $user = $request->user();

        try {
            app(AuthModule::class)->deleteCredential(
                (new DeleteCredentialRequest)
                    ->setDriver(DriverEnum::EMAIL)
                    ->setUser($user)
                    ->setIdentify($request->input('email'))
            );
        } catch (DisabledDriver) {
            throw ValidationException::withMessages(['email' => ['Phone driver is disabled']]);
        } catch (CredentialWithThisIdentifyNotExists) {
            throw ValidationException::withMessages(['email' => ["This user hasn't credential with this email"]]);
        }

        return response()->json(new ROperationResult(true));
    }
}
