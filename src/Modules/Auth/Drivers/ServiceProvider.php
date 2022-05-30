<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers;

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
        $this->app->register(Email\ServiceProvider::class);
        $this->app->register(Phone\ServiceProvider::class);
    }
}
