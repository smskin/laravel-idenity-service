<?php

use SMSkin\IdentityService\Http\Web\Controllers\OAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('oauth')->group(function () {
    Route::prefix('github')->group(function () {
        Route::get('/', [OAuthController::class, 'github'])->name('oauth.github');
        Route::get('callback', [OAuthController::class, 'githubCallback'])->name('oauth.github.callback');
    });
});
