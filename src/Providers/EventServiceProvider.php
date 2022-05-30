<?php

namespace SMSkin\IdentityService\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SMSkin\IdentityService\Models\UserEmailCredential;
use SMSkin\IdentityService\Models\UserEmailVerification;
use SMSkin\IdentityService\Models\UserPhoneVerification;
use SMSkin\IdentityService\Observers\PhoneVerificationObserver;
use SMSkin\IdentityService\Observers\UserEmailCredentialObserver;
use SMSkin\IdentityService\Observers\UserEmailVerificationObserver;
use SMSkin\IdentityService\Observers\UserObserver;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class EventServiceProvider extends ServiceProvider
{
    use ClassFromConfig;

    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        $this->getUserModel()::observe(UserObserver::class);
        UserPhoneVerification::observe(PhoneVerificationObserver::class);
        UserEmailCredential::observe(UserEmailCredentialObserver::class);
        UserEmailVerification::observe(UserEmailVerificationObserver::class);
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