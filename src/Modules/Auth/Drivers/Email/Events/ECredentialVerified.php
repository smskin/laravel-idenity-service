<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Events;

use SMSkin\IdentityService\Models\UserEmailCredential;
use SMSkin\IdentityService\Modules\Core\BaseEvent;

class ECredentialVerified extends BaseEvent
{
    public function __construct(public UserEmailCredential $credential){

    }
}
