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

        Route::post('sync', 'SyncController@sync')->name('sync');
        
        Route::namespace('Auth')->group(function() {
            Route::post('logout', 'LoginController@logout')->name('logout');
        });

        Route::namespace('Bookings')->group(function() {
            Route::post('walkin/reservation', 'WalkinController@reservation')->name('walkin.store');
            Route::post('add-new/guest', 'WalkinController@addNewGuest')->name('new.guest.store');
        });

        Route::namespace('Surveys')->group(function() {
            Route::post('survey-exp-answer/store', 'SurveyController@answer')->name('survey-experience.answer.store');
        });

        Route::namespace('Remarks')->group(function() {
            Route::post('remark/store', 'RemarkController@store')->name('remark.store');
        });

        Route::namespace('Feedbacks')->group(function() {
            Route::post('feedback/store', 'FeedbackController@store')->name('feedback.store');
        });

        Route::namespace('FetchControllers')->group(function() {
            Route::post('guests', 'GuestFetchController@fetch')->name('guest.fetch');
        });
        
        Route::post('fetch-resources', 'ResourceFetchController@fetch')->name('resources.fetch');
        Route::post('dashboard', 'ResourceFetchController@dashboard')->name('resources.dashboard');
        Route::post('device-token/store','DeviceTokenController@store')->name('device-token.store');

        Route::namespace('Frontliner')->group(function() {
            Route::post('/fronliner/details/update', 'UserController@update')->name('frontliner.details.update');

            Route::post('/frontliner/start/visit', 'VisitController@start')->name('frontliner.start.visit');
        });

        Route::namespace('Books')->group(function() {
            Route::post('/bookings', 'BookController@fetch')->name('bookings.fetch');
            Route::post('/total/walkin', 'BookController@remainingSeat')->name('bookings.remaining-seat');
            Route::post('/scan/qr', 'BookController@scan')->name('scan.qr');
            Route::post('/bookings/representative/update', 'BookController@updateRepresentative')->name('bookings.representative.update');
        });

        Route::namespace('Violations')->group(function() {
            Route::post('violation/store', 'ViolationController@store')->name('violation.store');
        });

        Route::namespace('Notifications')->group(function() {
            Route::get('/notifications', 'NotificationController@fetch')->name('notifications.fetch');
            Route::post('/notifications/read', 'NotificationController@read')->name('notifications.read');
        });
          
    });

    Route::namespace('Masungi')->group(function() {
        Route::namespace('Auth')->group(function() {
            Route::post('masungi/{option}', 'LoginController@login');
            // Route::post('masungi/login/device', 'LoginController@login')->name('masungi.invoice.store');
        });

        Route::group(['middleware' => ['assign.guard:masungi', 'jwt.auth']], function() {
            Route::namespace('Invoices')->group(function() {
                Route::post('masungi/invoice/store', 'InvoiceController@store')->name('masungi.invoice.store');
            });
        });
    });
});