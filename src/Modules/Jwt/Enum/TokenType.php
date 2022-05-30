<?php

namespace SMSkin\IdentityService\Modules\Jwt\Enum;

enum TokenType: string
{
    case ACCESS_TOKEN = 'ACCESS_TOKEN';
    case REFRESH_TOKEN = 'REFRESH_TOKEN';
}
