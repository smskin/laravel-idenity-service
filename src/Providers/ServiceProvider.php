<?php

namespace SMSkin\IdentityService\Providers;

use SMSkin\IdentityService\Modules\ModuleServiceProvider;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->loadConfig();

        if (app()->runningInConsole()) {
            $this->registerMigrations();
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();

        $this->app->register(AuthServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);

        $this->app->register(ModuleServiceProvider::class);
    }

    private function loadConfig()
    {
        $configPath = __DIR__ . '/../../config/identity-service.php';
        $this->publishes([
            $configPath => app()->configPath('identity-service.php'),
        ], 'identity-service');
    }

    private function registerConfig()
    {
        $configPath = __DIR__ . '/../../config/identity-service.php';
        $this->mergeConfigFrom($configPath, 'identity-service');
    }

    private function registerMigrations()
    {
        $this->publishes([
            __DIR__ . '/../../migrations' => database_path('migrations'),
        ], 'identity-service');

        $this->loadMigrationsFrom(__DIR__ . '/../../migrations');
    }
}