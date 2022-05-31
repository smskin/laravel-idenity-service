# About Identity service library

Identity service is a service that allows you to organize authorization in a laravel application through a common remote
server. This allows you to organize a multi-service architecture with end-to-end authorization.

Identity service library consists of 2 parts:

- identity service - this package. Master auth service.
- identity service client - a client that allows application users to log in through a shared
  service (https://github.com/smskin/laravel-identity-service-client)

## Installation

1. Run `composer require smskin/laravel-identity-service`
2. Run `php artisan vendor:publish --tag=identity-service`
3. Run `php artisan vendor:publish --tag=identity-service-client`
4. Configure identity service with `identity-service.php` in config folder and environments
5. Configure identity service client with `identity-service-client.php` in config folder and environments (read more in
   client readme file - https://github.com/smskin/laravel-identity-service-client/blob/main/README.md)

## Environments

- IDENTITY_SERVICE_NAME - uses in iss claim of jwt
- IDENTITY_SERVICE_MODULE_AUTH_REGISTRATION_ACTIVE - allows registration of new users
- IDENTITY_SERVICE_SECURITY_API_TOKEN - secret key for admin functionality (admin api)
- IDENTITY_SERVICE_MODULE_JWT_TTL_ACCESS - ttl of access token (in seconds)
- IDENTITY_SERVICE_MODULE_JWT_TTL_REFRESH - ttl of refresh token (in seconds)
- IDENTITY_SERVICE_MODULE_JWT_SECRET - secret key for signing jwt
- IDENTITY_SERVICE_MODULE_SIGNATURE_TOKEN - secret key for signing interservice requests

## Documentation

Controllers are described to maintain the swagger documentation. You can render documentation
with `darkaonline/l5-swagger` package.

Steps for render documentation:

1. Run `composer require darkaonline/l5-swagger`
2. Run `php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"`
3. Open `l5-swagger.php` in config folder
4. Add in `annotations` section (line 41 in default config file) after `base_path('app')` new element of
   array `base_path('vendor/smskin/laravel-identity-service/src/Http')`
5. Run `php artisan l5-swagger:generate`
6. Open swagger documentation page (by default: `http://localhost/api/documentation`)