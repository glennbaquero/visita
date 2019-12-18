<?php

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

Route::get('sandbox', 'SandboxController@index')->name('sandbox.index');


Route::namespace('Web')->name('web.')->group(function() {

	Route::namespace('Auth')->group(function() {

		/* Guest Routes */
		Route::middleware('guest:web')->group(function() {

	        Route::get('login', 'LoginController@showLoginForm')->name('login');
	        Route::post('login', 'LoginController@login');

	        Route::get('reset-password/{token}/{email}', 'ResetPasswordController@showResetForm')->name('password.reset');
	        Route::post('reset-password/change', 'ResetPasswordController@reset')->name('password.change');

	        Route::get('forgot-password', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
	        Route::post('forgot-password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');

	        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
	        Route::post('register', 'RegisterController@register');

	        /* Socialite Login */
	        Route::get('socialite/{provider}/login', 'SocialiteLoginController@login')->name('socialite.login');
			Route::get('socialite/{provider}/callback', 'SocialiteLoginController@callback')->name('socialite.callback');

			/* Facebook Login */
			Route::get('socialite/facebook/login', 'SocialiteLoginController@login')->name('facebook.login');
			Route::get('socialite/facebook/callback', 'SocialiteLoginController@callback')->name('facebook.callback');


			Route::middleware(['guest:management', 'cors'])->group(function() {

				Route::get('reset-password/frontliner/{token}/{email}', 'Frontliner\ResetPasswordController@showResetForm')->name('frontliner.password.reset');
				Route::post('forgot-password/frontliner/email', 'Frontliner\ForgotPasswordController@sendResetLinkEmail')->name('frontliner.password.email');
		        Route::post('reset-password/frontliner/change', 'Frontliner\ResetPasswordController@reset')->name('frontliner.password.change');
			});
		});

        Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');

	});

	/* Page Routes */
	Route::namespace('Pages')->group(function() {

		Route::get('', 'PageController@showHome')->name('home');
		Route::get('/about-us', 'PageController@showAboutUs')->name('about-us');
		Route::get('/destinations', 'PageController@showDestinations')->name('destinations');
		Route::get('/destinations-info', 'PageController@showDestinationsInfo')->name('destinations-info');
		Route::get('/faqs', 'PageController@showFaqs')->name('faqs');
		// Route::get('/fetch/destination', 'PageController@fetchDestination')->name('fetch.destination');
		Route::get('stylesheet', 'PageController@showStylesheet')->name('stylesheet');
		Route::get('/privacy-policy', 'PageController@showPrivacyPolicy')->name('privacy-policy');
		Route::get('/reset-password/success', 'PageController@frontlinerSuccessPage')->name('management.reset.password.success');

	});

	/* Inquiries Routes */
	Route::namespace('Inquiries')->group(function() {

		Route::post('inquiry', 'InquiryController@inquiryPost')->name('user.inquiry');

	});

	/* Article Routes */
	Route::namespace('Articles')->group(function() {
		
		Route::get('articles', 'ArticleController@index')->name('articles.index');
		Route::get('articles/show/{id}/{slug?}', 'ArticleController@show')->name('articles.show');

		Route::post('articles/fetch', 'ArticleFetchController@fetch')->name('articles.fetch');
		Route::post('articles/fetch-item/{id?}', 'ArticleFetchController@fetchView')->name('articles.fetch-item');
		Route::post('articles/fetch-pagination/{id}', 'ArticleFetchController@fetchPagePagination')->name('articles.fetch-pagination');
	});


	/* Destination Routes */
	Route::namespace('Destinations')->group(function() {

		Route::get('/fetch/destination', 'DestinationFetchController@fetchDestination')->name('fetch.destination');

	});


	/* User Dashboard Routes */
	Route::prefix('dashboard')->middleware('auth:web')->group(function() {

		Route::namespace('Auth')->group(function() {

			Route::get('logout', 'LoginController@logout')->name('logout');

	        Route::get('email/reset', 'VerificationController@resend')->name('verification.resend');
	        Route::get('email/verify', 'VerificationController@show')->name('verification.notice');

		});

		Route::middleware('verified')->group(function() {

			Route::get('', 'DashboardController@index')->name('dashboard');

			/**
	         * @Count Fetch Controller
	         */
	        Route::post('count/notifications', 'CountFetchController@fetchNotificationCount')->name('counts.fetch.notifications');

			Route::namespace('Profiles')->group(function() {

	            /**
	             * @Profiles
	             */
	            Route::get('profile', 'ProfileController@show')->name('profiles.show');
	            Route::post('profile/update', 'ProfileController@update')->name('profiles.update');
	            Route::post('profile/change-password', 'ProfileController@changePassword')->name('profiles.change-password');

	            Route::post('profile/fetch', 'ProfileController@fetch')->name('profiles.fetch');

	        });

			Route::namespace('Notifications')->group(function() {

	            Route::get('notifications', 'NotificationController@index')->name('notifications.index');
	            Route::post('notifications/all/mark-as-read', 'NotificationController@readAll')->name('notifications.read-all');
	            Route::post('notifications/{id}/read', 'NotificationController@read')->name('notifications.read');
	            Route::post('notifications/{id}/unread', 'NotificationController@unread')->name('notifications.unread');
	            
	            Route::post('notifications-fetch', 'NotificationFetchController@fetch')->name('notifications.fetch');
	            Route::post('notifications-fetch?read=1', 'NotificationFetchController@fetch')->name('notifications.fetch-read');
	            Route::post('notifications-fetch?unread=1', 'NotificationFetchController@fetch')->name('notifications.fetch-unread');

	        });

			Route::namespace('ActivityLogs')->group(function() {

	            Route::get('activity-logs', 'ActivityLogController@index')->name('activity-logs.index');
	            
	            Route::post('activity-logs/fetch', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch');
	            Route::post('activity-logs/fetch?id={id}&sample=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.sample-items');
	            Route::post('activity-logs/fetch?profile=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.profiles');

	        });

	        Route::namespace('Samples')->group(function() {

				Route::get('sample-items', 'SampleItemController@index')->name('sample-items.index');
				Route::get('sample-items/create', 'SampleItemController@create')->name('sample-items.create');
				Route::post('sample-items/store', 'SampleItemController@store')->name('sample-items.store');
				Route::get('sample-items/show/{id}', 'SampleItemController@show')->name('sample-items.show');
				Route::post('sample-items/update/{id}', 'SampleItemController@update')->name('sample-items.update');
				Route::post('sample-items/{id}/archive', 'SampleItemController@archive')->name('sample-items.archive');
			    Route::post('sample-items/{id}/restore', 'SampleItemController@restore')->name('sample-items.restore');
			    Route::post('sample-items/{id}/remove-image', 'SampleItemController@removeImage')->name('sample-items.remove-image');

			    Route::post('sample-items/{id}/approve', 'SampleItemController@approve')->name('sample-items.approve');
			    Route::post('sample-items/{id}/deny', 'SampleItemController@deny')->name('sample-items.deny');

				Route::post('sample-items/fetch', 'SampleItemFetchController@fetch')->name('sample-items.fetch');
				Route::post('sample-items/fetch?archived=1', 'SampleItemFetchController@fetch')->name('sample-items.fetch-archive');
				Route::post('sample-items/fetch-item/{id?}', 'SampleItemFetchController@fetchView')->name('sample-items.fetch-item');
				Route::post('sample-items/fetch-pagination/{id}', 'SampleItemFetchController@fetchPagePagination')->name('sample-items.fetch-pagination');

			});



		});

	});

});


