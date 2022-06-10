<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Commands;

use Illuminate\Validation\ValidationException;
use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Controllers\CRemoveInactiveVerifications;
use SMSkin\LaravelSupport\BaseCommand;

class RemoveInactiveVerifications extends BaseCommand
{
    protected $signature = 'modules:auth:drivers:email:verifications:clear-inactive';

    /**
     * @return int
     * @throws ValidationException
     */
    public function handle(): int
    {
        (new CRemoveInactiveVerifications)->execute();

        return 0;
    }
}
