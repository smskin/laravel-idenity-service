<?php

namespace SMSkin\IdentityService\Modules\Jwt\Controllers;

use SMSkin\LaravelSupport\BaseController;
use SMSkin\LaravelSupport\BaseRequest;
use SMSkin\IdentityService\Modules\Jwt\Enum\TokenType;
use SMSkin\IdentityService\Modules\Jwt\Models\Jwt;
use SMSkin\IdentityService\Modules\Jwt\Models\JwtContext;
use SMSkin\IdentityService\Modules\Jwt\Models\Token;
use SMSkin\IdentityService\Modules\Jwt\Requests\GenerateAccessTokenRequest;
use Illuminate\Support\Str;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use MiladRahimi\Jwt\Exceptions\JsonEncodingException;
use MiladRahimi\Jwt\Exceptions\SigningException;
use MiladRahimi\Jwt\Generator;

class CGenerateAccessToken extends BaseController
{
    protected GenerateAccessTokenRequest|BaseRequest|null $request;

    protected ?string $requestClass = GenerateAccessTokenRequest::class;

    /**
     * @return self
     * @throws JsonEncodingException
     * @throws SigningException
     */
    public function execute(): static
    {
        $jti = Str::uuid()->toString();
        $generator = new Generator($this->getSigner());

        $this->result = (new Jwt())
            ->setAccessToken($this->getAccessToken($generator, $jti))
            ->setRefreshToken($this->getRefreshToken($generator, $jti));
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
     * @return HS256
     */
    private function getSigner(): HS256
    {
        return app(HS256::class);
    }

    /**
     * @param Generator $generator
     * @param string $jti
     * @return Token
     * @throws JsonEncodingException
     * @throws SigningException
     */
    private function getAccessToken(Generator $generator, string $jti): Token
    {
        $expiredAt = now()->addSeconds(config('identity-service.modules.jwt.ttl.access'));
        $value = $generator->generate(
            (new JwtContext)
                ->setType(TokenType::ACCESS_TOKEN)
                ->setSub($this->request->subject)
                ->setScopes($this->request->scopes)
                ->setExp($expiredAt)
                ->setIat(now()->timestamp)
                ->setJti($jti)
                ->toArray()
        );
        return (new Token())
            ->setValue($value)
            ->setExpiresIn(config('identity-service.modules.jwt.ttl.access'))
            ->setExpireAt($expiredAt);
    }

    /**
     * @param Generator $generator
     * @param string $jti
     * @return Token
     * @throws JsonEncodingException
     * @throws SigningException
     */
    private function getRefreshToken(Generator $generator, string $jti): Token
    {
        $expiredAt = now()->addSeconds(config('identity-service.modules.jwt.ttl.refresh'));
        $value = $generator->generate(
            (new JwtContext)
                ->setType(TokenType::REFRESH_TOKEN)
                ->setSub($this->request->subject)
                ->setScopes($this->request->scopes)
                ->setExp($expiredAt)
                ->setIat(now()->timestamp)
                ->setJti($jti)
                ->toArray()
        );
        return (new Token())
            ->setValue($value)
            ->setExpiresIn(config('identity-service.modules.jwt.ttl.refresh'))
            ->setExpireAt($expiredAt);
    }
}
