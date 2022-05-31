<?php

namespace SMSkin\IdentityService\Modules\Scope;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use SMSkin\IdentityService\Modules\Scope\Commands\SyncScopes;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            SyncScopes::class
        ]);
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {

    }
}