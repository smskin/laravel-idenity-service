<?php

namespace SMSkin\IdentityService\Modules\Auth;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use SMSkin\IdentityService\Modules\Auth\Commands\GenerateOAuthSignature;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * http://localhost:81/identity-service/oauth/github?callback-url=http://localhost:81/test&key=bsdsbj&signature=872e0f9cf2f1aaf643d275e80777a58cfaec3c81
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
