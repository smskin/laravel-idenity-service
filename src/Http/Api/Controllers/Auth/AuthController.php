<?php

namespace SMSkin\IdentityService\Http\Api\Controllers\Auth;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use MiladRahimi\Jwt\Exceptions\InvalidSignatureException;
use MiladRahimi\Jwt\Exceptions\InvalidTokenException;
use MiladRahimi\Jwt\Exceptions\JsonDecodingException;
use MiladRahimi\Jwt\Exceptions\JsonEncodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use MiladRahimi\Jwt\Exceptions\ValidationException as JwtValidationException;
use OpenApi\Annotations\JsonContent;
use OpenApi\Annotations\Parameter;
use OpenApi\Annotations\Post;
use SMSkin\IdentityService\Http\Api\Controllers\Controller;
use SMSkin\IdentityService\Http\Api\Requests\Auth\RefreshJwtRequest;
use SMSkin\IdentityService\Http\Api\Resources\Auth\RJwt;
use SMSkin\IdentityService\Modules\Auth\Exceptions\InvalidScopes;
use SMSkin\IdentityService\Modules\Jwt\JwtModule;
use SMSkin\IdentityService\Modules\Jwt\Requests\RefreshAccessTokenRequest;
use SMSkin\IdentityService\Traits\ClassFromConfig;
use SyncMutex;
use function app;
use function response;

class AuthController extends Controller
{
    use ClassFromConfig;

    /**
     * @Post(
     *     path="/identity-service/api/auth/jwt/refresh",
     *     tags={"Auth"},
     *     summary="Обновление JWT Access token по Refresh token",
     *     @Parameter(
     *          name="token",
     *          description="Refresh token",
     *          in="query",
     *          required=true
     *     ),
     *     @Parameter(
     *          name="scopes",
     *          description="Scopes",
     *          in="query",
     *          required=false
     *     ),
     *     @\OpenApi\Annotations\Response(response="200", description="Successful operation", @JsonContent(ref="#/components/schemas/RJwt")),
     *     @\OpenApi\Annotations\Response(response="422", description="Validation exception")
     * )
     *
     * @param RefreshJwtRequest $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws Exception
     */
    public function refreshJwt(RefreshJwtRequest $request): JsonResponse
    {
        $token = $request->input('token');
        $mutex = new SyncMutex(sha1($token));
        if (!$mutex->lock(10000)) {
            throw new Exception('Can\'t lock (' . static::class . '@refreshJwt) within 10 seconds');
        }

        try {
            $jwt = app(JwtModule::class)->refreshAccessToken(
                (new RefreshAccessTokenRequest)
                    ->setToken($token)
                    ->setScopes($request->input('scopes'))
            );
        } catch (JsonEncodingException|SigningException|InvalidSignatureException|InvalidTokenException|JsonDecodingException|JwtValidationException) {
            throw ValidationException::withMessages(['token' => ['Invalid token']]);
        } catch (InvalidScopes $exception) {
            throw ValidationException::withMessages(['scopes' => ["User hasn't this scopes: " . implode(', ', $exception->scopes)]]);
        } finally {
            $mutex->unlock();
        }

        return response()->json(new RJwt($jwt));
    }
}
