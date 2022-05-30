<?php

namespace SMSkin\IdentityService\Modules\Jwt;

use SMSkin\IdentityService\Modules\Jwt\Tools\InvalidatedTokenStorage;
use SMSkin\IdentityService\Modules\Jwt\Tools\JwtGuard;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->extend(config('identity-service.modules.jwt.guard.name'), function ($app, $name, array $config) {
            $guard = new JWTGuard(
                $app['auth']->createUserProvider($config['provider']),
                $app['request'],
                $app['events']
            );

            $app->refresh('request', $guard, 'setRequest');

            return $guard;
        });

        config(['auth.guards.identity-service-jwt' => [
            'driver' => config('identity-service.modules.jwt.guard.name'),
            'provider' => 'users',
        ]]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(HS256::class, function () {
            return new HS256(config('identity-service.modules.jwt.secret'));
        });

        $this->app->singleton(InvalidatedTokenStorage::class, function (){
            return new InvalidatedTokenStorage();
        });
    }
}
