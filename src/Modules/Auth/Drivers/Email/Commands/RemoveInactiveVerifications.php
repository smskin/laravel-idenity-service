<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email\Commands;

use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Controllers\CRemoveInactiveVerifications;
use SMSkin\IdentityService\Modules\Core\BaseCommand;

class RemoveInactiveVerifications extends BaseCommand
{
    protected $signature = 'modules:auth:drivers:email:verifications:clear-inactive';

    public function handle(): int
    {
        app(CRemoveInactiveVerifications::class)->execute();

        return 0;
    }
}
