<?php

namespace SMSkin\IdentityService\Http\Api\Controllers\Auth;

use SMSkin\IdentityService\Http\Api\Controllers\Controller;
use SMSkin\IdentityService\Http\Api\Requests\Auth\Email\AuthorizeByEmailRequest;
use SMSkin\IdentityService\Http\Api\Requests\Auth\Email\RegisterByEmailRequest;
use SMSkin\IdentityService\Http\Api\Requests\Auth\Email\ValidateEmailCredentialsRequest;
use SMSkin\IdentityService\Http\Api\Resources\Auth\RJwt;
use SMSkin\IdentityService\Http\Api\Resources\ROperationResult;
use SMSkin\IdentityService\Modules\Auth\AuthModule;
use SMSkin\IdentityService\Modules\Auth\Enums\DriverEnum;
use SMSkin\IdentityService\Modules\Auth\Exceptions\DisabledDriver;
use SMSkin\IdentityService\Modules\Auth\Exceptions\InvalidPassword;
use SMSkin\IdentityService\Modules\Auth\Exceptions\InvalidScopes;
use SMSkin\IdentityService\Modules\Auth\Exceptions\RegistrationDisabled;
use SMSkin\IdentityService\Modules\Auth\Exceptions\ThisIdentifyAlreadyUsesByAnotherUser;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UnsupportedDriver;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UserAlreadyHasCredentialWithThisIdentify;
use SMSkin\IdentityService\Modules\Auth\Requests\LoginRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\RegisterRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\ValidateRequest;
use SMSkin\IdentityService\Modules\Jwt\JwtModule;
use SMSkin\IdentityService\Modules\Jwt\Requests\GenerateAccessTokenByUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use MiladRahimi\Jwt\Exceptions\JsonEncodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use OpenApi\Annotations\JsonContent;
use OpenApi\Annotations\Parameter;
use OpenApi\Annotations\Post;
use SMSkin\IdentityService\Traits\ClassFromConfig;
use Throwable;

class EmailController extends Controller
{
    use ClassFromConfig;

    /**
     * @Post(
     *     path="/identity-service/api/auth/email/register",
     *     tags={"Auth"},
     *     summary="Регистрация по E-mail",
     *     @Parameter(
     *          name="name",
     *          description="Имя пользователя",
     *          in="query",
     *          required=true
     *     ),
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
     *     @\OpenApi\Annotations\Response(response="200", description="Successful operation", @JsonContent(ref="#/components/schemas/RJwt")),
     *     @\OpenApi\Annotations\Response(response="422", description="Validation exception")
     * )
     *
     * @param RegisterByEmailRequest $request
     * @return JsonResponse
     * @throws UnsupportedDriver
     * @throws Throwable
     */
    public function registerByEmail(RegisterByEmailRequest $request): JsonResponse
    {
        try {
            $user = app(AuthModule::class)->registration(
                (new RegisterRequest)
                    ->setDriver(DriverEnum::EMAIL)
                    ->setName($request->input('name'))
                    ->setIdentify($request->input('email'))
                    ->setPassword($request->input('password'))
            );
        } catch (RegistrationDisabled) {
            throw ValidationException::withMessages(['email' => ['Registration disabled']]);
        } catch (ThisIdentifyAlreadyUsesByAnotherUser) {
            throw ValidationException::withMessages(['email' => ['Email already uses by another user']]);
        } catch (UserAlreadyHasCredentialWithThisIdentify) {
            throw ValidationException::withMessages(['email' => ['You already has account with this email']]);
        }

        $jwt = app(JwtModule::class)->generateAccessTokenByUser(
            (new GenerateAccessTokenByUserRequest)
                ->setUser($user)
                ->setScopes([
                    self::getSystemChangeScope()
                ])
        );

        return response()->json(new RJwt($jwt));
    }

    /**
     * @Post(
     *     path="/identity-service/api/auth/email/validate",
     *     tags={"Auth"},
     *     summary="Проверка пароля по E-mail",
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
     *     @\OpenApi\Annotations\Response(response="422", description="Validation exception")
     * )
     *
     * @param ValidateEmailCredentialsRequest $request
     * @return JsonResponse
     * @throws UnsupportedDriver
     * @throws ValidationException
     */
    public function validateByEmail(ValidateEmailCredentialsRequest $request): JsonResponse
    {
        try {
            $result = app(AuthModule::class)->validate(
                (new ValidateRequest)
                    ->setDriver(DriverEnum::EMAIL)
                    ->setIdentify($request->input('email'))
                    ->setPassword($request->input('password'))
            );
        } catch (DisabledDriver) {
            throw ValidationException::withMessages(['email' => ['Email driver is disabled']]);
        }

        return response()->json(new ROperationResult($result));
    }

    /**
     * @Post(
     *     path="/identity-service/api/auth/email/authorize",
     *     tags={"Auth"},
     *     summary="Авторизация по E-mail",
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
     *     @Parameter(
     *          name="scopes",
     *          description="Scopes",
     *          in="query",
     *          required=true,
     *          example="system:change-scopes"
     *     ),
     *     @\OpenApi\Annotations\Response(response="200", description="Successful operation", @JsonContent(ref="#/components/schemas/RJwt")),
     *     @\OpenApi\Annotations\Response(response="422", description="Validation exception")
     * )
     *
     * @param AuthorizeByEmailRequest $request
     * @return JsonResponse
     * @throws JsonEncodingException
     * @throws SigningException
     * @throws UnsupportedDriver
     * @throws ValidationException
     */
    public function authorizeByEmail(AuthorizeByEmailRequest $request): JsonResponse
    {
        try {
            $user = app(AuthModule::class)->login(
                (new LoginRequest)
                    ->setDriver(DriverEnum::EMAIL)
                    ->setIdentify($request->input('email'))
                    ->setPassword($request->input('password'))
                    ->setScopes($request->input('scopes'))
            );
        } catch (InvalidPassword) {
            throw ValidationException::withMessages(['password' => ['Invalid password']]);
        } catch (InvalidScopes $exception) {
            throw ValidationException::withMessages(['scopes' => ["User hasn't this scopes: " . implode(', ', $exception->scopes)]]);
        } catch (DisabledDriver) {
            throw ValidationException::withMessages(['email' => ['Email driver is disabled']]);
        }

        $jwt = app(JwtModule::class)->generateAccessTokenByUser(
            (new GenerateAccessTokenByUserRequest)
                ->setUser($user)
                ->setScopes($request->input('scopes'))
        );

        return response()->json(new RJwt($jwt));
    }
}
