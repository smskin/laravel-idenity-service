<?php

namespace SMSkin\IdentityService\Modules;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(Core\ServiceProvider::class);
        $this->app->register(Jwt\ServiceProvider::class);
        $this->app->register(User\ServiceProvider::class);
        $this->app->register(Auth\ServiceProvider::class);
    }
}
