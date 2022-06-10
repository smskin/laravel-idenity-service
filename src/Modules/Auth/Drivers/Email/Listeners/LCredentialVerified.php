<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Listeners;

use Illuminate\Validation\ValidationException;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Controllers\CCancelVerificationsByCredential;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Events\ECredentialVerified;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Requests\ExistCredentialRequest;
use SMSkin\LaravelSupport\BaseListener;

class LCredentialVerified extends BaseListener
{
    /**
     * @param ECredentialVerified $event
     * @return void
     * @throws ValidationException
     */
    public function handle(ECredentialVerified $event)
    {
        (new CCancelVerificationsByCredential(
            (new ExistCredentialRequest)
                ->setCredential($event->credential)
        ))->execute();
    }
}
