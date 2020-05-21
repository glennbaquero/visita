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

	Route::namespace('Pages')->group(function() {
		Route::get('/request-to-visit/{id?}/{name?}', 'PageController@showRequestToVisit')->name('request-to-visit');
	});

	Route::namespace('Auth')->group(function() {

        Route::get('email/verify/{id}/{user}', 'VerificationController@verify')->name('verification.verify');
        
        Route::middleware('auth:web')->group(function() {
	        Route::get('logout', 'LoginController@logout')->name('logout');
	    });

		/* Guest Routes */
		Route::middleware('guest:web')->group(function() {

	        Route::get('sign-in', 'LoginController@showLoginForm')->name('login');
	        Route::post('sign-in', 'LoginController@login')->name('user.login');

	        Route::get('reset-password/{token}/{email}', 'ResetPasswordController@showResetForm')->name('password.reset');
	        Route::post('reset-password/change', 'ResetPasswordController@reset')->name('password.change');

	        Route::get('forgot-password', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
	        Route::post('forgot-password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');

	        // Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
	        Route::post('register', 'RegisterController@register')->name('register');

	        /* Socialite Login */
	        Route::get('socialite/{provider}/login', 'SocialiteLoginController@login')->name('socialite.login');
			Route::get('socialite/{provider}/callback', 'SocialiteLoginController@callback')->name('socialite.callback');

			/* Facebook Login */
			Route::get('socialite/facebook/login', 'SocialiteLoginController@login')->name('facebook.login');
			Route::get('socialite/facebook/callback', 'SocialiteLoginController@callback')->name('facebook.callback');
			
			/* Google Login */
			Route::get('google/login', 'SocialiteGoogleLoginController@login')->name('google.login');
			Route::get('google/callback', 'SocialiteGoogleLoginController@callback')->name('google.callback');

			Route::middleware(['guest:management', 'cors'])->group(function() {

				Route::get('reset-password/frontliner/{token}/{email}', 'Frontliner\ResetPasswordController@showResetForm')->name('frontliner.password.reset');
				Route::post('forgot-password/frontliner/email', 'Frontliner\ForgotPasswordController@sendResetLinkEmail')->name('frontliner.password.email');
		        Route::post('reset-password/frontliner/change', 'Frontliner\ResetPasswordController@reset')->name('frontliner.password.change');
			});
		});
	});

	/* Page Routes */
	Route::namespace('Pages')->group(function() {
		Route::middleware('guest:web')->group(function() {
			// Route::get('/login', 'PageController@showLogin')->name('login');
			Route::get('/sign-up', 'PageController@showSignUp')->name('sign-up');
		});

		Route::get('', 'PageController@showHome')->name('home');
		Route::get('/read/{type}', 'PageController@showPolicies')->name('home');
		Route::get('/about-us', 'PageController@showAboutUs')->name('about-us');
		
		Route::get('/destinations', 'PageController@showDestinations')->name('destinations');
		Route::get('/destinations/info/{id}/{name}', 'PageController@showDestinationsInfo')->name('destinations-info');
		
		Route::get('/faqs', 'PageController@showFaqs')->name('faqs');
		Route::get('/contact-us', 'PageController@showContactUs')->name('contact-us');
		
		Route::get('/forgot-password', 'PageController@showForgotPassword')->name('forgot-password');
		// Route::get('/reset-password/{token}/{email}', 'PageController@showResetPassword')->name('password.reset');
		
		Route::get('stylesheet', 'PageController@showStylesheet')->name('stylesheet');
		Route::get('/privacy-policy', 'PageController@showPrivacyPolicy')->name('privacy-policy');
		Route::get('/reset-password/success', 'PageController@frontlinerSuccessPage')->name('management.reset.password.success');

		Route::middleware('auth:web')->group(function() {
			// Route::get('/request-to-visit/{id}/{name}', 'PageController@showRequestToVisit')->name('request-to-visit');
			Route::get('/user/dashboard', 'PageController@showDashboard')->name('dashboard');
			Route::get('/user/profile', 'PageController@showProfile')->name('profile');
			Route::post('/timeslot/available', 'PageController@getTimeSlot')->name('getTimeSlot');
		});
	});

	Route::namespace('Users')->group(function() {
		Route::middleware('auth:web')->group(function() {
			Route::post('/user/update/{id}', 'UserController@update')->name('user.update');
			Route::post('/user/update-password/{id}', 'UserController@updatePassword')->name('user.update-password');
		});
	});

	Route::namespace('Paypal')->group(function() {
		Route::middleware('auth:web')->group(function() {
			Route::post('/paypal/transaction', 'PaypalController@transaction')->name('transaction');
		});
	});

	Route::namespace('Invoices')->group(function() {
		Route::middleware('auth:web')->group(function() {
			Route::post('/book/store', 'InvoiceController@store')->name('book.store');
			Route::post('reservation/get', 'InvoiceController@show')->name('reservations.show');
			Route::post('upload/deposit', 'InvoiceController@uploadDepositSlip')->name('upload.deposit');
			Route::post('/generate/form', 'InvoiceController@generatePaynamicsForm')->name('book.generate-form');
		});
		
		Route::post('checkout/processPaynamics', 'InvoiceController@processPaynamics')->name('checkout.process_paynamics');
		Route::get('checkout/paynamicsReturn', 'InvoiceController@paynamicsReturn')->name('checkout.paynamics_return');        
		Route::get('checkout/paynamicsCancel', 'InvoiceController@paynamicsCancel')->name('checkout.paynamics-cancel');
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
});


