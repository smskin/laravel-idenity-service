<?php

use SMSkin\IdentityService\Http\Api\Controllers\Identity\IdentityController;
use SMSkin\IdentityService\Http\Api\Controllers\UserController;
use SMSkin\IdentityService\Models\User;
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
            'user' => User::class
        ],
        'enums' => [
            'scope_groups' => ScopeGroups::class
        ],
        'policies' => [
            'scope' => ScopePolicy::class,
            'scope_group' => ScopeGroupPolicy::class,
            'user' => UserPolicy::class
        ],
        'controllers' => [
            'identity' => IdentityController::class,
            'user' => UserController::class
        ]
    ],
    'host' => [
        'prefix' => 'identity-service',
        'api_token' => env('IDENTITY_SERVICE_HOST_API_TOKEN'),
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