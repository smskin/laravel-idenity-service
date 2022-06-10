<?php

use SMSkin\IdentityService\Http\Api\Controllers\Auth\AuthController;
use SMSkin\IdentityService\Http\Api\Controllers\Auth\EmailController as AuthEmailController;
use SMSkin\IdentityService\Http\Api\Controllers\Auth\PhoneController as AuthPhoneController;
use SMSkin\IdentityService\Http\Api\Controllers\Identity\IdentityController;
use SMSkin\IdentityService\Http\Api\Controllers\Identity\IdentityEmailController;
use SMSkin\IdentityService\Http\Api\Controllers\Identity\IdentityPhoneController;
use SMSkin\IdentityService\Http\Api\Controllers\OAuthController;
use Illuminate\Support\Facades\Route;

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
});

Route::prefix('oauth')->group(function () {
    Route::get('validate-signature', [OAuthController::class, 'validateSignature']);
});

Route::prefix('identity')->group(function () {
    Route::get('/', [IdentityController::class, 'show'])
        ->withoutMiddleware(['throttle:api'])
        ->middleware(['throttle:unlimited']);
    Route::get('scopes', [IdentityController::class, 'getScopes']);
    Route::put('/', [IdentityController::class, 'update']);
    Route::post('impersonate', [IdentityController::class, 'impersonate']);
    Route::get('logout', [IdentityController::class, 'logout']);

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