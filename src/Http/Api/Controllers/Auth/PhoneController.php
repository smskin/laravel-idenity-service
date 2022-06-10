<?php

namespace SMSkin\IdentityService\Http\Api\Controllers\Auth;

use SMSkin\IdentityService\Http\Api\Controllers\Controller;
use SMSkin\IdentityService\Http\Api\Requests\Auth\Phone\AuthorizeByPhoneRequest;
use SMSkin\IdentityService\Http\Api\Requests\Auth\Phone\RegisterByPhoneRequest;
use SMSkin\IdentityService\Http\Api\Requests\Auth\Phone\SubmitPhoneVerificationCodeRequest;
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
use SMSkin\IdentityService\Modules\Auth\Exceptions\VerificationAlreadyInitialized;
use SMSkin\IdentityService\Modules\Auth\Requests\LoginRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\RegisterRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\SendPhoneVerificationCodeRequest;
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

class PhoneController extends Controller
{
    use ClassFromConfig;

    /**
     * @Post(
     *     path="/identity-service/api/auth/phone/submit-verification-code",
     *     tags={"Auth"},
     *     summary="Отправка одноразового кода",
     *     @Parameter(
     *          name="phone",
     *          description="Номер мобильного телефона",
     *          in="query",
     *          required=true
     *     ),
     *    @\OpenApi\Annotations\Response(response="200", description="Successful operation", @JsonContent(ref="#/components/schemas/ROperationResult")),
     *    @\OpenApi\Annotations\Response(response="422", description="Validation exception")
     * )
     *
     * @param SubmitPhoneVerificationCodeRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function submitPhoneVerificationCode(SubmitPhoneVerificationCodeRequest $request): JsonResponse
    {
        try {
            (new AuthModule)->sendPhoneVerificationCode(
                (new SendPhoneVerificationCodeRequest)->setPhone(
                    $request->input('phone')
                )
            );
        } catch (VerificationAlreadyInitialized) {
            throw ValidationException::withMessages(['phone' => ['Verification code already sent']]);
        } catch (DisabledDriver) {
            throw ValidationException::withMessages(['phone' => ['Phone driver is disabled']]);
        }

        return response()->json(new ROperationResult(true));
    }

    /**
     * @Post(
     *     path="/identity-service/api/auth/phone/register",
     *     tags={"Auth"},
     *     summary="Регистрация по номеру телефона",
     *     @Parameter(
     *          name="name",
     *          description="Имя пользователя",
     *          in="query",
     *          required=true
     *     ),
     *     @Parameter(
     *          name="phone",
     *          description="Номер мобильного телефона",
     *          in="query",
     *          required=true
     *     ),
     *     @Parameter(
     *          name="code",
     *          description="Код из СМС сообщения",
     *          in="query",
     *          required=true
     *     ),
     *     @\OpenApi\Annotations\Response(response="200", description="Successful operation", @JsonContent(ref="#/components/schemas/RJwt")),
     *     @\OpenApi\Annotations\Response(response="422", description="Validation exception")
     * )
     *
     * @param RegisterByPhoneRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function registerByPhone(RegisterByPhoneRequest $request): JsonResponse
    {
        try {
            $user = (new AuthModule)->registration(
                (new RegisterRequest)
                    ->setDriver(DriverEnum::PHONE)
                    ->setName($request->input('name'))
                    ->setIdentify($request->input('phone'))
                    ->setPassword($request->input('code'))
            );
        } catch (RegistrationDisabled) {
            throw ValidationException::withMessages(['phone' => ['Registration disabled']]);
        } catch (InvalidPassword) {
            throw ValidationException::withMessages(['code' => ['Invalid password']]);
        } catch (ThisIdentifyAlreadyUsesByAnotherUser) {
            throw ValidationException::withMessages(['phone' => ['Phone already uses by another user']]);
        } catch (UserAlreadyHasCredentialWithThisIdentify) {
            throw ValidationException::withMessages(['phone' => ['You already has account with this phone']]);
        }

        $jwt = (new JwtModule)->generateAccessTokenByUser(
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
     *     path="/identity-service/api/auth/phone/authorize",
     *     tags={"Auth"},
     *     summary="Авторизация по номеру телефона",
     *     @Parameter(
     *          name="phone",
     *          description="Номер мобильного телефона",
     *          in="query",
     *          required=true
     *     ),
     *     @Parameter(
     *          name="code",
     *          description="Код из СМС сообщения",
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
     * @param AuthorizeByPhoneRequest $request
     * @return JsonResponse
     * @throws JsonEncodingException
     * @throws SigningException
     * @throws UnsupportedDriver
     * @throws ValidationException
     */
    public function authorizeByPhone(AuthorizeByPhoneRequest $request): JsonResponse
    {
        try {
            $user = (new AuthModule)->login(
                (new LoginRequest)
                    ->setDriver(DriverEnum::PHONE)
                    ->setIdentify($request->input('phone'))
                    ->setPassword($request->input('code'))
                    ->setScopes($request->input('scopes'))
            );
        } catch (InvalidPassword) {
            throw ValidationException::withMessages(['code' => ['Invalid password']]);
        } catch (InvalidScopes $exception) {
            throw ValidationException::withMessages(['scopes' => ["User hasn't this scopes: " . implode(', ', $exception->scopes)]]);
        } catch (DisabledDriver) {
            throw ValidationException::withMessages(['phone' => ['Phone driver is disabled']]);
        }

        $jwt = (new JwtModule)->generateAccessTokenByUser(
            (new GenerateAccessTokenByUserRequest)
                ->setUser($user)
                ->setScopes($request->input('scopes'))
        );

        return response()->json(new RJwt($jwt));
    }
}
