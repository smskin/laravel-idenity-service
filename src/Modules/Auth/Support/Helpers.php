<?php

namespace SMSkin\IdentityService\Modules\Auth\Support;

class Helpers
{
    public static function clearPhone(string $phone): string
    {
        return preg_replace('/[^0-9+]/', '', $phone);
    }
}
