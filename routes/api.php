<?php

use SMSkin\IdentityService\Http\Api\Controllers\Auth\AuthController;
use SMSkin\IdentityService\Http\Api\Controllers\Auth\EmailController as AuthEmailController;
use SMSkin\IdentityService\Http\Api\Controllers\Auth\PhoneController as AuthPhoneController;
use SMSkin\IdentityService\Http\Api\Controllers\Identity\IdentityEmailController;
use SMSkin\IdentityService\Http\Api\Controllers\Identity\IdentityPhoneController;
use SMSkin\IdentityService\Http\Api\Controllers\OAuthController;
use Illuminate\Support\Facades\Route;
use SMSkin\IdentityService\Http\Api\Controllers\ScopeController;
use SMSkin\IdentityService\Http\Api\Controllers\ScopeGroupController;
use SMSkin\IdentityService\Http\Api\Middleware\ApiToken;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::prefix('email')->group(function () {
        Route::post('register', [AuthEmailController::class, 'registerByEmail']);
        Route::post('validate', [AuthEmailController::class, 'validateByEmail']);
        Route::post('authorize', [AuthEmailController::class, 'authorizeByEmail']);
        Route::get('verify-by-code', [AuthEmailController::class, 'verifyEmailByCode']);
    });

    Route::prefix('phone')->group(function () {
        Route::post('submit-verification-code', [AuthPhoneController::class, 'submitPhoneVerificationCode']);
        Route::post('register', [AuthPhoneController::class, 'registerByPhone']);
        Route::post('authorize', [AuthPhoneController::class, 'authorizeByPhone']);
    });

    Route::prefix('jwt')->group(function () {
        Route::post('refresh', [AuthController::class, 'refreshJwt'])
            ->withoutMiddleware(['throttle:api'])
            ->middleware(['throttle:unlimited']);
    });

    Route::post('impersonate', [AuthController::class, 'impersonate'])
        ->middleware([ApiToken::class]);
});

Route::prefix('oauth')->group(function () {
    Route::get('validate-signature', [OAuthController::class, 'validateSignature']);
});

Route::prefix('identity')->group(function () {
    $identityController = config('identity-service.classes.controllers.identity');
    Route::get('/', [$identityController, 'show'])
        ->withoutMiddleware(['throttle:api'])
        ->middleware(['throttle:unlimited']);
    Route::get('scopes', [$identityController, 'getScopes']);
    Route::put('/', [$identityController, 'update']);
    Route::post('impersonate', [$identityController, 'impersonate']);
    Route::get('logout', [$identityController, 'logout']);

    Route::prefix('email')->group(function () {
        Route::post('/', [IdentityEmailController::class, 'assign']);
        Route::put('/', [IdentityEmailController::class, 'updatePassword']);
        Route::delete('/', [IdentityEmailController::class, 'deleteEmail']);
    });

    Route::prefix('phone')->group(function () {
        Route::post('/', [IdentityPhoneController::class, 'assign']);
        Route::delete('/', [IdentityPhoneController::class, 'deletePhone']);
    });
});

Route::prefix('scope-groups')->group(function () {
    Route::get('/', [ScopeGroupController::class, 'getList']);
    Route::prefix('{groupId}')->group(function () {
        Route::get('scopes', [ScopeGroupController::class, 'getScopes']);
    });
});

Route::prefix('scopes')->group(function () {
    Route::get('/', [ScopeController::class, 'getList']);
});

Route::prefix('users')->group(function () {
    $userController = config('identity-service.classes.controllers.user');
    Route::get('/', [$userController, 'getList']);
    Route::post('/', [$userController, 'create']);
    Route::prefix('{userId}')->group(function () use ($userController) {
        Route::get('/', [$userController, 'show']);
        Route::put('/', [$userController, 'update']);
        Route::get('scope-groups', [$userController, 'getScopeGroups']);
        Route::post('scope-groups', [$userController, 'assignScopeGroup']);
        Route::get('scopes', [$userController, 'getScopes']);
        Route::post('scopes', [$userController, 'assignScope']);
    });
});