<?php

namespace SMSkin\IdentityService\Modules\Auth;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use SMSkin\IdentityService\Modules\Auth\Commands\GenerateOAuthSignature;

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
            GenerateOAuthSignature::class
        ]);

        $this->app->register(Drivers\ServiceProvider::class);
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
