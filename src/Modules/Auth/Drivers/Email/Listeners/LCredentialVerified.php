<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Listeners;

use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Controllers\CCancelVerificationsByCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Events\ECredentialVerified;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\ExistCredentialRequest;
use SMSkin\LaravelSupport\BaseListener;

class LCredentialVerified extends BaseListener
{
    public function handle(ECredentialVerified $event)
    {
        app(CCancelVerificationsByCredential::class, [
            'request' => (new ExistCredentialRequest)
                ->setCredential($event->credential)
        ])->execute();
    }
}
