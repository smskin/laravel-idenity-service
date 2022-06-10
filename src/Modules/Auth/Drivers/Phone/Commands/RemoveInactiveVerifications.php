<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Commands;

use Illuminate\Validation\ValidationException;
use SMSkin\IdentityService\Modules\Auth\Drivers\Phone\Controllers\CRemoveInactiveVerifications;
use SMSkin\LaravelSupport\BaseCommand;

class RemoveInactiveVerifications extends BaseCommand
{
    protected $signature = 'modules:auth:drivers:phone:verifications:clear-inactive';

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
