<?php

namespace SMSkin\IdentityService\Modules\Jwt\Tools;

use SMSkin\IdentityService\Modules\Auth\AuthModule;
use SMSkin\IdentityService\Modules\Auth\Enums\DriverEnum;
use SMSkin\IdentityService\Modules\Auth\Exceptions\DisabledDriver;
use SMSkin\IdentityService\Modules\Auth\Exceptions\UnsupportedDriver;
use SMSkin\IdentityService\Modules\Auth\Requests\ValidateRequest;
use SMSkin\IdentityService\Modules\Jwt\JwtModule;
use SMSkin\IdentityService\Modules\Jwt\Models\JwtContext;
use SMSkin\IdentityService\Modules\Jwt\Requests\DecodeTokenRequest;
use SMSkin\IdentityService\Modules\Jwt\Requests\InvalidateAccessTokenRequest;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use MiladRahimi\Jwt\Exceptions\InvalidSignatureException;
use MiladRahimi\Jwt\Exceptions\InvalidTokenException;
use MiladRahimi\Jwt\Exceptions\JsonDecodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use MiladRahimi\Jwt\Exceptions\ValidationException as JwtValidationException;
use SMSkin\IdentityService\Traits\ClassFromConfig;
use Throwable;

class JwtGuard implements IJwtGuard
{
    use ClassFromConfig;

    use GuardHelpers {
        setUser as guardHelperSetUser;
    }

    /**
     * The user we last attempted to retrieve.
     *
     * @var Authenticatable
     */
    protected Authenticatable $lastAttempted;

    /**
     * The request instance.
     *
     * @var Request
     */
    protected Request $request;

    /**
     * The event dispatcher instance.
     *
     * @var Dispatcher
     */
    protected Dispatcher $events;

    protected ?JwtContext $jwt = null;

    /**
     * Instantiate the class.
     *
     * @return void
     */
    public function __construct(UserProvider $provider, Request $request, Dispatcher $eventDispatcher)
    {
        $this->provider = $provider;
        $this->request = $request;
        $this->events = $eventDispatcher;
    }

    public function user(): ?Authenticatable
    {
        if ($this->user !== null) {
            return $this->user;
        }

        $token = $this->getTokenFromRequest();
        if (!$token) {
            return null;
        }

        try {
            $this->jwt = (new JwtModule)->decodeAccessToken(
                (new DecodeTokenRequest)->setToken($token)
            );
        } catch (Throwable) {
            return null;
        }

        return $this->user = self::getUserModel()::where('identity_uuid', $this->jwt->sub)->first();
    }

    /**
     * @param array $credentials
     * @return bool
     * @throws DisabledDriver
     * @throws UnsupportedDriver
     * @throws ValidationException
     */
    public function validate(array $credentials = []): bool
    {
        return (new AuthModule)->validate(
            (new ValidateRequest)
                ->setDriver(DriverEnum::EMAIL)
                ->setIdentify($credentials['email'])
                ->setPassword($credentials['password'])
        );
    }

    public function getJwt(): ?JwtContext
    {
        return $this->jwt;
    }

    /**
     * @return void
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     * @throws JsonDecodingException
     * @throws JwtValidationException
     * @throws SigningException
     * @throws ValidationException
     */
    public function logout(): void
    {
        (new JwtModule)->invalidateAccessToken(
            (new InvalidateAccessTokenRequest)->setJwt($this->jwt)
        );
    }

    private function getTokenFromRequest(): ?string
    {
        $header = $this->getAuthorizationHeader();
        if ($header) {
            $start = strlen('bearer');

            return trim(substr($header, $start));
        }
        return null;
    }

    private function getAuthorizationHeader(): ?string
    {
        $header = $this->request->headers->get('authorization');
        if ($header) {
            return $header;
        }
        $header = $this->request->server->get('HTTP_AUTHORIZATION');
        if ($header) {
            return $header;
        }
        $header = $this->request->server->get('REDIRECT_HTTP_AUTHORIZATION');
        if ($header) {
            return $header;
        }
        return null;
    }
}
