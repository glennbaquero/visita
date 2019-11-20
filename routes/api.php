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
->middleware(['cors'])
->namespace('API')
->group(function() {

    Route::post('config/fetch','ConfigFetchController@fetch')->name('fetch.config');

    Route::namespace('Auth')->group(function() {

        Route::post('login', 'LoginController@login')->name('login');
        Route::post('register', 'RegisterController@register')->name('register');
        Route::post('email/reset', 'VerificationController@resend')->name('verification.resend');

    });
    Route::group(['middleware' => ['assign.guard:api', 'jwt.auth']], function() {
        
        Route::namespace('Auth')->group(function() {
            Route::post('logout', 'LoginController@logout')->name('logout');
        });

        Route::namespace('Bookings')->group(function() {
            Route::post('walkin/reservation', 'WalkinController@reservation')->name('walkin.store');
        });

        Route::namespace('Surveys')->group(function() {
            Route::post('survey-exp-answer/store', 'SurveyController@answer')->name('survey-experience.answer.store');
        });

        Route::namespace('FetchControllers')->group(function() {
            Route::post('guests', 'GuestFetchController@fetch')->name('guest.fetch');
        });
        
        Route::post('fetch-resources', 'ResourceFetchController@fetch')->name('resources.fetch');
        Route::post('dashboard', 'ResourceFetchController@dashboard')->name('resources.dashboard');
        Route::post('device-token/store','DeviceTokenController@store')->name('device-token.store');

        Route::namespace('Frontliner')->group(function() {
            Route::post('/fronliner/details/update', 'UserController@update')->name('frontliner.details.update');
        });

        Route::namespace('Books')->group(function() {
            Route::post('/bookings', 'BookController@fetch')->name('bookings.fetch');
        });
          
    });
});