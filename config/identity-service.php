<?php

use SMSkin\IdentityService\Models\Scope;
use SMSkin\IdentityService\Models\ScopeGroup;
use SMSkin\IdentityService\Models\User;
use SMSkin\IdentityService\Models\UserEmailCredential;
use SMSkin\IdentityService\Models\UserEmailVerification;
use SMSkin\IdentityService\Models\UserOAuthCredential;
use SMSkin\IdentityService\Models\UserPhoneCredential;
use SMSkin\IdentityService\Models\UserPhoneVerification;
use SMSkin\IdentityService\Modules\Auth\Enums\DriverEnum as AuthDriverEnum;
use SMSkin\IdentityService\Modules\OAuth\Enums\DriverEnum as OAuthDriverEnum;
use SMSkin\IdentityService\Modules\Sms\Drivers\Log\LogDriver;
use SMSkin\IdentityService\Modules\Sms\Enums\DriverEnum as SmsDriverEnum;
use SMSkin\IdentityService\Policies\ScopeGroupPolicy;
use SMSkin\IdentityService\Policies\ScopePolicy;
use SMSkin\IdentityService\Policies\UserPolicy;
use SMSkin\IdentityServiceClient\Enums\ScopeGroups;
use SMSkin\IdentityServiceClient\Enums\Scopes;

return [
    'name' => env('IDENTITY_SERVICE_NAME', 'Identity service'),
    'classes' => [
        'models' => [
            'user' => User::class,
            'scope' => Scope::class,
            'scope_group' => ScopeGroup::class
        ],
        'enums' => [
            'scope_groups' => ScopeGroups::class
        ],
        'policies' => [
            'scope' => ScopePolicy::class,
            'scope_group' => ScopeGroupPolicy::class,
            'user' => UserPolicy::class
        ]
    ],
    'host' => [
        'prefix' => 'identity-service'
    ],
    'modules' => [
        'auth' => [
            'registration' => [
                'active' => env('IDENTITY_SERVICE_MODULE_AUTH_REGISTRATION_ACTIVE', false)
            ],
            'scopes' => [
                'system_change_scope' => Scopes::SYSTEM_CHANGE_SCOPES
            ],
            'auth' => [
                'drivers' => [
                    AuthDriverEnum::EMAIL,
                    AuthDriverEnum::PHONE
                ]
            ],
            'oauth' => [
                'drivers' => [
                    OAuthDriverEnum::GITHUB
                ]
            ]
        ],
        'jwt' => [
            'guard' => [
                'name' => 'identity-service-jwt'
            ],
            'ttl' => [
                'access' => env('IDENTITY_SERVICE_MODULE_JWT_TTL_ACCESS', 600),
                'refresh' => env('IDENTITY_SERVICE_MODULE_JWT_TTL_REFRESH', 604800)
            ],
            'secret' => env('IDENTITY_SERVICE_MODULE_JWT_SECRET'),
        ],
        'signature' => [
            'token' => env('IDENTITY_SERVICE_MODULE_SIGNATURE_TOKEN'),
        ],
        'sms' => [
            'driver' => SmsDriverEnum::LOG,
            'drivers' => [
                'log' => [
                    'driver' => LogDriver::class,
                    'channel' => env('LOG_CHANNEL', 'stack')
                ]
            ]
        ]
    ],
];