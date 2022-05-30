<?php

namespace SMSkin\IdentityService\Modules\Jwt\Models;

use SMSkin\IdentityService\Modules\Jwt\Enum\TokenType;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

class JwtContext implements Arrayable
{
    public string $iss;
    public TokenType $type;
    public string $sub;
    public array $scopes;
    public Carbon $exp;
    public int $iat;
    public string $jti;

    public function __construct()
    {
        $this->iss = config('identity-service.name', 'Identity service');
    }

    public function fromArray(array $data): self
    {
        $this->iss = $data['iss'];
        $this->type = TokenType::from($data['type']);
        $this->sub = $data['sub'];
        $this->scopes = $data['scopes'];
        $this->exp = Carbon::createFromTimestamp($data['exp']);
        $this->iat = $data['iat'];
        $this->jti = $data['jti'];
        return $this;
    }

    public function toArray(): array
    {
        return [
            'iss' => $this->iss,
            'type' => $this->type->value,
            'sub' => $this->sub,
            'scopes' => $this->scopes,
            'exp' => $this->exp->timestamp,
            'iat' => $this->iat,
            'jti' => $this->jti
        ];
    }

    /**
     * @param TokenType $type
     * @return JwtContext
     */
    public function setType(TokenType $type): JwtContext
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $sub
     * @return JwtContext
     */
    public function setSub(string $sub): JwtContext
    {
        $this->sub = $sub;
        return $this;
    }

    /**
     * @param Carbon $exp
     * @return JwtContext
     */
    public function setExp(Carbon $exp): JwtContext
    {
        $this->exp = $exp;
        return $this;
    }

    /**
     * @param int $iat
     * @return JwtContext
     */
    public function setIat(int $iat): JwtContext
    {
        $this->iat = $iat;
        return $this;
    }

    /**
     * @param string $jti
     * @return JwtContext
     */
    public function setJti(string $jti): JwtContext
    {
        $this->jti = $jti;
        return $this;
    }

    /**
     * @param array $scopes
     * @return JwtContext
     */
    public function setScopes(array $scopes): JwtContext
    {
        $this->scopes = $scopes;
        return $this;
    }
}
