<?php

namespace SMSkin\IdentityService\Modules\Jwt\Controllers;

use Illuminate\Database\Eloquent\Model;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Modules\Auth\Exceptions\InvalidScopes;
use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\Jwt\Models\Jwt;
use SMSkin\IdentityService\Modules\Jwt\Models\JwtContext;
use SMSkin\IdentityService\Modules\Jwt\Requests\DecodeTokenRequest;
use SMSkin\IdentityService\Modules\Jwt\Requests\GenerateAccessTokenRequest;
use SMSkin\IdentityService\Modules\Jwt\Requests\RefreshAccessTokenRequest;
use SMSkin\IdentityService\Modules\Jwt\Requests\InvalidateAccessTokenRequest;
use Illuminate\Support\Facades\Cache;
use MiladRahimi\Jwt\Exceptions\InvalidSignatureException;
use MiladRahimi\Jwt\Exceptions\InvalidTokenException;
use MiladRahimi\Jwt\Exceptions\JsonDecodingException;
use MiladRahimi\Jwt\Exceptions\JsonEncodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use MiladRahimi\Jwt\Exceptions\ValidationException;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class CRefreshAccessToken extends BaseController
{
    use ClassFromConfig;

    protected RefreshAccessTokenRequest|BaseRequest|null $request;

    protected ?string $requestClass = RefreshAccessTokenRequest::class;

    /**
     * @return self
     * @throws InvalidScopes
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     * @throws JsonDecodingException
     * @throws JsonEncodingException
     * @throws SigningException
     * @throws ValidationException
     */
    public function execute(): self
    {
        $jwt = $this->getTokenFromMultiThreadCache();
        if ($jwt) {
            $this->result = $jwt;
            return $this;
        }

        $jwt = $this->decodeToken();
        $this->result = $this->generateAccessToken($jwt);
        $this->revokeToken($jwt);
        $this->putTokenToMultiThreadCache($this->result);
        return $this;
    }

    /**
     * @return Jwt
     */
    public function getResult(): Jwt
    {
        return parent::getResult();
    }

    /**
     * @return JwtContext
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     * @throws JsonDecodingException
     * @throws SigningException
     * @throws ValidationException
     */
    private function decodeToken(): JwtContext
    {
        return app(CDecodeRefreshToken::class, [
            'request' => (new DecodeTokenRequest())
                ->setToken($this->request->token)
        ])->execute()->getResult();
    }

    /**
     * @param JwtContext $jwt
     * @return Jwt
     * @throws InvalidScopes
     * @throws JsonEncodingException
     * @throws SigningException
     */
    private function generateAccessToken(JwtContext $jwt): Jwt
    {
        return app(CGenerateAccessToken::class, [
            'request' => (new GenerateAccessTokenRequest)
                ->setSubject($jwt->sub)
                ->setScopes($this->getScopes($jwt))
        ])->execute()->getResult();
    }

    /**
     * @param JwtContext $jwt
     * @return void
     * @throws InvalidSignatureException
     * @throws InvalidTokenException
     * @throws JsonDecodingException
     * @throws SigningException
     * @throws ValidationException
     */
    private function revokeToken(JwtContext $jwt)
    {
        app(CInvalidateAccessToken::class, [
            'request' => (new InvalidateAccessTokenRequest())
                ->setJwt($jwt)
        ])->execute();
    }

    private function getTokenFromMultiThreadCache(): ?Jwt
    {
        $data = Cache::get($this->getMultiThreadCacheKey());
        if (!$data) {
            return null;
        }

        return (new Jwt())->fromArray($data);
    }

    private function putTokenToMultiThreadCache(Jwt $jwt): void
    {
        Cache::put($this->getMultiThreadCacheKey(), $jwt->toArray(), 10);
    }

    private function getMultiThreadCacheKey(): string
    {
        return 'multi_thread_cache_' . md5($this->request->token);
    }

    /**
     * @param JwtContext $jwt
     * @return array
     * @throws InvalidScopes
     */
    private function getScopes(JwtContext $jwt): array
    {
        if (!in_array($this->getSystemChangeScope(), $jwt->scopes) || !$this->request->scopes) {
            return $jwt->scopes;
        }

        $failed = [];
        $user = $this->getUserByJwt($jwt);
        $scopes = $user->getScopes()->pluck('slug')->toArray();
        foreach ($this->request->scopes as $scope) {
            if (!in_array($scope, $scopes)) {
                $failed[] = $scope;
            }
        }
        if (count($failed)) {
            throw new InvalidScopes($failed);
        }
        return $this->request->scopes;
    }

    /**
     * @param JwtContext $jwt
     * @return User
     */
    private function getUserByJwt(JwtContext $jwt): Model
    {
        return $this->getUserModel()::where('identity_uuid', $jwt->sub)->firstOrFail();
    }
}
