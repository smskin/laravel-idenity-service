<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Events;

use SMSkin\IdentityService\Models\UserEmailCredential;
use SMSkin\LaravelSupport\BaseEvent;

class ECredentialVerified extends BaseEvent
{
    public function __construct(public UserEmailCredential $credential){

    }
}
