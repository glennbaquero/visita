<?php

use Illuminate\Http\Request;

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

Route::name('api.')
->middleware(['cors', 'api.device'])
->namespace('API')
->group(function() {

    Route::post('config/fetch','ConfigFetchController@fetch')->name('fetch.config');

    Route::namespace('Auth')->group(function() {

        Route::post('login', 'LoginController@login')->name('login');
        Route::post('register', 'RegisterController@register')->name('register');

    });

    Route::group(['middleware' => ['assign.guard:web', 'jwt.auth', 'api.auth:web']], function() {

    	Route::namespace('Auth')->group(function() {
            
            Route::post('email/reset', 'VerificationController@resend')->name('verification.resend');

        });

        Route::post('fetch-resources', 'ResourceFetchController@fetch')->name('resources.fetch');

        Route::post('device-token/store','DeviceTokenController@store')->name('device-token.store');
          
    });
});