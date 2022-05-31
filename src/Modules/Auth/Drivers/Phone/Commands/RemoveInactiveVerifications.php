<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Commands;

use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers\CRemoveInactiveVerifications;
use SMSkin\LaravelSupport\BaseCommand;

class RemoveInactiveVerifications extends BaseCommand
{
    protected $signature = 'modules:auth:drivers:phone:verifications:clear-inactive';

    public function handle(): int
    {
        app(CRemoveInactiveVerifications::class)->execute();

        return 0;
    }
}
