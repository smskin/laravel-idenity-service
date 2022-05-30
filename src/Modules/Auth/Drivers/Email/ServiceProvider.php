<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email;

use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Commands\RemoveInactiveVerifications;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            RemoveInactiveVerifications::class
        ]);
    }
}
