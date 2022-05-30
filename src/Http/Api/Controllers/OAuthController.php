<?php

namespace SMSkin\IdentityService\Http\Api\Controllers;

use SMSkin\IdentityService\Http\Api\Requests\OAuth\GetOAuthLinkRequest;
use SMSkin\IdentityService\Http\Api\Resources\ROperationResult;
use SMSkin\IdentityService\Modules\Signature\Requests\ValidateSignatureRequest;
use SMSkin\IdentityService\Modules\Signature\SignatureModule;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\JsonContent;
use OpenApi\Annotations\Parameter;

class OAuthController extends Controller
{
    /**
     * @Get(
     *     path="/identity-service/api/oauth/validate-signature",
     *     tags={"OAuth"},
     *     summary="Проверка подписи",
     *     description="Алгоритм вычисления подписи: <br> $source = $callbackUrl . '|' . SECURITY_API_SIGNATURE_TOKEN . '|' . $key; <br> $signature = sha1(strtolower($source));",
     *     @Parameter(
     *          name="callback-url",
     *          description="URL обратного ридеректа",
     *          in="query",
     *          required=true
     *     ),
     *     @Parameter(
     *          name="key",
     *          description="Некая сигнатура текущего пользователя. Потребуется для проверки ответа",
     *          in="query",
     *          required=true
     *     ),
     *     @Parameter(
     *          name="signature",
     *          description="Подпись запроса",
     *          in="query",
     *          required=true
     *     ),
     *     @\OpenApi\Annotations\Response(response="200", description="Successful operation", @JsonContent(ref="#/components/schemas/ROperationResult")),
     *     @\OpenApi\Annotations\Response(response="422", description="Validation exception"),
     * )
     *
     * @param GetOAuthLinkRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function validateSignature(GetOAuthLinkRequest $request): JsonResponse
    {
        $result = app(SignatureModule::class)->validate(
            (new ValidateSignatureRequest)
                ->setValue(sha1($request->input('callback-url')))
                ->setSalt($request->input('key'))
                ->setSignature($request->input('signature'))
        );

        return response()->json(new ROperationResult($result));
    }
}
