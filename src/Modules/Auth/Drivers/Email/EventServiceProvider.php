<?php

namespace SMSkin\IdentityService\Modules\Auth\Drivers\Email;

use SMSkin\IdentityService\Modules\Auth\Drivers\Email\Events\ECredentialVerified;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        ECredentialVerified::class => [
            Listeners\LCredentialVerified::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
