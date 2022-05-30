<?php

namespace SMSkin\IdentityService\Modules\Jwt\Tools;

use Illuminate\Support\Facades\Cache;
use function config;

class InvalidatedTokenStorage
{
    public function putJti(string $jti)
    {
        $key = 'jti_' . $jti;
        Cache::tags(['jwt', 'jwt-jti'])->put($key, $jti, config('identity-service.modules.jwt.ttl.refresh'));
    }

    public function hasByJti(string $jti): bool
    {
        $key = 'jti_' . $jti;
        return Cache::tags(['jwt', 'jwt-jti'])->has($key);
    }
}
