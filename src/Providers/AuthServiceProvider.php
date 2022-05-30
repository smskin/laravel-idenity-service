<?php

namespace SMSkin\IdentityService\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use SMSkin\IdentityService\Models\Scope;
use SMSkin\IdentityService\Models\ScopeGroup;
use SMSkin\IdentityService\Policies\ScopeGroupPolicy;
use SMSkin\IdentityService\Policies\ScopePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Scope::class => ScopePolicy::class,
        ScopeGroup::class => ScopeGroupPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
