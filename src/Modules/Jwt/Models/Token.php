<?php

namespace SMSkin\IdentityService\Modules\Jwt\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

class Token implements Arrayable
{
    public string $value;
    public int $expiresIn;
    public Carbon $expireAt;

    /**
     * @param int $expiresIn
     * @return Token
     */
    public function setExpiresIn(int $expiresIn): Token
    {
        $this->expiresIn = $expiresIn;
        return $this;
    }

    /**
     * @param Carbon $expireAt
     * @return Token
     */
    public function setExpireAt(Carbon $expireAt): Token
    {
        $this->expireAt = $expireAt;
        return $this;
    }

    /**
     * @param string $value
     * @return Token
     */
    public function setValue(string $value): Token
    {
        $this->value = $value;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'expiresIn' => $this->expiresIn,
            'expireAt' => $this->expireAt->toIso8601String(),
            'value' => $this->value
        ];
    }

    public function fromArray(array $data): self
    {
        $this->expiresIn = $data['expiresIn'];
        $this->expireAt = Carbon::make($data['expireAt']);
        $this->value = $data['value'];
        return $this;
    }
}
