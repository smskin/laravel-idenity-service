<?php

namespace SMSkin\IdentityService\Modules\Jwt\Models;

use Illuminate\Contracts\Support\Arrayable;

class Jwt implements Arrayable
{
    public Token $accessToken;
    public Token $refreshToken;

    /**
     * @param Token $accessToken
     * @return Jwt
     */
    public function setAccessToken(Token $accessToken): Jwt
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * @param Token $refreshToken
     * @return Jwt
     */
    public function setRefreshToken(Token $refreshToken): Jwt
    {
        $this->refreshToken = $refreshToken;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'accessToken' => $this->accessToken->toArray(),
            'refreshToken' => $this->refreshToken->toArray()
        ];
    }

    public function fromArray(array $data): static
    {
        $this->accessToken = (new Token())->fromArray($data['accessToken']);
        $this->refreshToken = (new Token())->fromArray($data['refreshToken']);
        return $this;
    }
}
