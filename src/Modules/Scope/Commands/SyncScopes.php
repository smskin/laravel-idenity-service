<?php

namespace SMSkin\IdentityService\Modules\Scope\Commands;

use Illuminate\Validation\ValidationException;
use SMSkin\LaravelSupport\BaseCommand;
use SMSkin\IdentityService\Modules\Scope\Controllers\CSyncScopeGroupsAndScopes;

class SyncScopes extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'identity-service:scopes:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync scopes in database with enum';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws ValidationException
     */
    public function handle(): int
    {
        (new CSyncScopeGroupsAndScopes)->execute();
        return 0;
    }
}
