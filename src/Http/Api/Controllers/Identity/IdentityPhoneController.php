<?php

namespace SMSkin\IdentityService\Http\Api\Controllers\Identity;

use SMSkin\IdentityService\Http\Api\Controllers\Controller;
use SMSkin\IdentityService\Http\Api\Requests\Identity\Phone\AssignPhoneRequest;
use SMSkin\IdentityService\Http\Api\Requests\Identity\Phone\DeletePhoneRequest;
use SMSkin\IdentityService\Http\Api\Resources\ROperationResult;
use SMSkin\IdentityService\Modules\Auth\AuthModule;
use SMSkin\IdentityService\Modules\Auth\Enums\DriverEnum;
use SMSkin\IdentityService\Modules\Auth\Exceptions\CredentialWithThisIdentifyNotExists;
use SMSkin\IdentityService\Modules\Auth\Exceptions\DisabledDriver;
use SMSkin\IdentityService\Modules\Auth\Exceptions\InvalidPassword;
use SMSkin\IdentityService\Modules\Auth\Exceptions\ThisIdentifyAlreadyUsesByAnotherUser;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UnsupportedDriver;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UserAlreadyHasCredentialWithThisIdentify;
use SMSkin\IdentityService\Modules\Auth\Exceptions\VerificationAlreadyCanceled;
use SMSkin\IdentityService\Modules\Auth\Requests\AssignPhoneToUserRequest;
use SMSkin\IdentityService\Modules\Auth\Requests\DeleteCredentialRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations\Delete;
use OpenApi\Annotations\JsonContent;
use OpenApi\Annotations\Parameter;
use OpenApi\Annotations\Post;
use function response;

class IdentityPhoneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:identity-service-jwt');
    }

    /**
     * @Post(
     *     path="/identity-service/api/identity/phone",
     *     tags={"Identity"},
     *     summary="Добавление телефона к учетной записи пользователя",
     *     @Parameter(
     *          name="phone",
     *          description="Номер телефона",
     *          in="query",
     *          required=true
     *     ),
     *     @Parameter(
     *          name="code",
     *          description="Код из СМС сообщения",
     *          in="query",
     *          required=true
     *     ),
     *     @\OpenApi\Annotations\Response(response="200", description="Successful operation", @JsonContent(ref="#/components/schemas/ROperationResult")),
     *     @\OpenApi\Annotations\Response(response="422", description="Validation exception"),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @param AssignPhoneRequest $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws VerificationAlreadyCanceled
     */
    public function assign(AssignPhoneRequest $request): JsonResponse
    {
        $user = $request->user();

        try {
            (new AuthModule)->assignPhoneToUserByCode(
                (new AssignPhoneToUserRequest)
                    ->setUser($user)
                    ->setPhone($request->input('phone'))
                    ->setCode($request->input('code'))
            );
        } catch (ThisIdentifyAlreadyUsesByAnotherUser) {
            throw ValidationException::withMessages(['phone' => ['Phone already uses by another user']]);
        } catch (UserAlreadyHasCredentialWithThisIdentify) {
            throw ValidationException::withMessages(['phone' => ['You already has account with this phone']]);
        } catch (InvalidPassword) {
            throw ValidationException::withMessages(['code' => ['Invalid code']]);
        } catch (DisabledDriver) {
            throw ValidationException::withMessages(['phone' => ['Phone driver is disabled']]);
        }

        return response()->json(new ROperationResult(true));
    }

    /**
     * @Delete(
     *     path="/identity-service/api/identity/phone",
     *     tags={"Identity"},
     *     summary="Удаление телефона к учетной записи пользователя",
     *     @Parameter(
     *          name="phone",
     *          description="Номер телефона",
     *          in="query",
     *          required=true
     *     ),
     *     @\OpenApi\Annotations\Response(response="200", description="Successful operation", @JsonContent(ref="#/components/schemas/ROperationResult")),
     *     @\OpenApi\Annotations\Response(response="422", description="Validation exception"),
     *     security={{"bearerAuth": {}}}
     * )
     *
     * @param DeletePhoneRequest $request
     * @return JsonResponse
     * @throws UnsupportedDriver
     * @throws ValidationException
     */
    public function deletePhone(DeletePhoneRequest $request): JsonResponse
    {
        $user = $request->user();

        try {
            (new AuthModule)->deleteCredential(
                (new DeleteCredentialRequest)
                    ->setDriver(DriverEnum::PHONE)
                    ->setUser($user)
                    ->setIdentify($request->input('phone'))
            );
        } catch (CredentialWithThisIdentifyNotExists) {
            throw ValidationException::withMessages(['phone' => ["This user hasn't credential with this phone"]]);
        } catch (DisabledDriver) {
            throw ValidationException::withMessages(['phone' => ['Phone driver is disabled']]);
        }

        return response()->json(new ROperationResult(true));
    }
}
