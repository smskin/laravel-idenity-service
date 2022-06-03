<?php

namespace SMSkin\IdentityService\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use SMSkin\IdentityService\Http\Api\Middleware\ForceJsonResponse;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->mapApiRoutes();
            $this->mapWebRoutes();
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('unlimited', function () {
            return Limit::none();
        });
    }

    private function mapApiRoutes()
    {
        Route::middleware([
            ForceJsonResponse::class
        ])
            ->name('identity-service.')
            ->namespace('SMSkin\IdentityService\Http\Api\Controllers')
            ->prefix(config('identity-service.host.prefix') . '/api')
            ->group(__DIR__ . '/../../routes/api.php');
    }

    private function mapWebRoutes()
    {
        Route::middleware('web')
            ->name('identity-service.')
            ->namespace('SMSkin\IdentityService\Http\Web\Controllers')
            ->prefix(config('identity-service.host.prefix'))
            ->group(__DIR__ . '/../../routes/web.php');
    }
}