<?php

namespace SMSkin\IdentityService\Http\Web\Controllers;

use SMSkin\IdentityService\Http\Web\Requests\OAuth\OAuthRequest;
use SMSkin\IdentityService\Modules\Auth\Exceptions\DisabledDriver;
use SMSkin\IdentityService\Modules\Auth\Exceptions\RegistrationDisabled;
use SMSkin\IdentityService\Modules\OAuth\Enums\DriverEnum;
use SMSkin\IdentityService\Modules\OAuth\Exceptions\DriverCredentialsNotDefined;
use SMSkin\IdentityService\Modules\OAuth\Exceptions\InvalidSignature;
use SMSkin\IdentityService\Modules\OAuth\Exceptions\RemoteIdAlreadyAssignedToAnotherUser;
use SMSkin\IdentityService\Modules\OAuth\Models\Callback;
use SMSkin\IdentityService\Modules\OAuth\OAuthModule;
use SMSkin\IdentityService\Modules\OAuth\Requests\GetRedirectorRequest;
use SMSkin\IdentityService\Modules\OAuth\Requests\ProcessCallbackRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use MiladRahimi\Jwt\Exceptions\JsonEncodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use OpenApi\Annotations\Parameter;
use OpenApi\Annotations\Get;

class OAuthController extends Controller
{
    /**
     * @Get(
     *     path="/identity-service/oauth/github",
     *     tags={"OAuth"},
     *     summary="Инициализация OAuth авторизации через Github",
     *     description="Данный запрос защищен подписью. <br> Алгоритм вычисления подписи: <br> $source = $callbackUrl . '|' . SECURITY_API_SIGNATURE_TOKEN . '|' . $key; <br> $signature = sha1(strtolower($source)); <br><br> При обратном редиректе вы получите 2 GET параметра: <ul><li>value - jwt ключ в base64 (модель RJwt)</li><li>signature - подпись запроса</li></ul> <p> Подпись можно проверить алгоритмом <br> $source = $value . '|' . SECURITY_API_SIGNATURE_TOKEN . '|' . $key; <br> $signature = sha1(strtolower($source));</p>",
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
     *     @\OpenApi\Annotations\Response(response="302", description="Successful operation")
     * )
     *
     * @param OAuthRequest $request
     * @return RedirectResponse
     * @throws DisabledDriver
     * @throws InvalidSignature
     * @throws ValidationException
     * @throws DriverCredentialsNotDefined
     */
    public function github(OAuthRequest $request): RedirectResponse
    {
        return app(OAuthModule::class)->getRedirector(
            (new GetRedirectorRequest)
                ->setDriver(DriverEnum::GITHUB)
                ->setCallback(
                    (new Callback())
                        ->setKey($request->input('key'))
                        ->setUrl($request->input('callback-url'))
                )
                ->setSignature($request->input('signature'))
        );
    }

    /**
     * @return RedirectResponse
     * @throws DisabledDriver
     * @throws JsonEncodingException
     * @throws RegistrationDisabled
     * @throws RemoteIdAlreadyAssignedToAnotherUser
     * @throws SigningException
     * @throws ValidationException
     */
    public function githubCallback(): RedirectResponse
    {
        return app(OAuthModule::class)->processCallback(
            (new ProcessCallbackRequest())
                ->setDriver(DriverEnum::GITHUB)
        );
    }
}
