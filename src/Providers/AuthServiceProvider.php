<?php

namespace SMSkin\IdentityService\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use SMSkin\IdentityService\Models\Scope;
use SMSkin\IdentityService\Models\ScopeGroup;
use SMSkin\IdentityService\Traits\ClassFromConfig;

class AuthServiceProvider extends ServiceProvider
{
    use ClassFromConfig;

    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [];

    public function policies(): array
    {
        return array_merge(
            $this->policies,
            [
                Scope::class => self::getScopePolicyClass(),
                ScopeGroup::class => self::getScopeGroupPolicyClass(),
                self::getUserModelClass() => self::getUserPolicyClass()
            ]
        );
    }

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
