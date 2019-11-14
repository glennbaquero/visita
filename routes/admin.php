<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/
/* Login Page*/

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function() {

    Route::namespace('Auth')->middleware('guest:admin')->group(function() {

        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login')->name('login');

        Route::get('reset-password/{token}/{email}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('reset-password/change', 'ResetPasswordController@reset')->name('password.change');

        Route::get('forgot-password', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('forgot-password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');

    });

    Route::middleware('auth:admin')->group(function() {

        Route::post('sortable', 'SortableController@sort')->name('sortable');
        Route::post('sortable?image=1', 'SortableController@sort')->name('sort.image');

        Route::namespace('Auth')->group(function() {

            Route::get('logout', 'LoginController@logout')->name('logout');

        });

        Route::get('', 'DashboardController@index')->name('dashboard');

        Route::post('fetch/address-position', '\App\Http\Controllers\GoogleAPIController@fetchAddressPosition')->name('google.fetch.address-position');

        /**
         * @Count Fetch Controller
         */
        Route::post('count/notifications', 'CountFetchController@fetchNotificationCount')->name('counts.fetch.notifications');
        Route::post('count/sample-items', 'CountFetchController@fetchSampleItemCount')->name('counts.fetch.sample-items.pending');
        
        /**
         * @Analytics
         */
        Route::namespace('Analytics')->group(function() {

            Route::post('analytics/dashboard', 'DashboardAnalyticsController@fetch')->name('analytics.fetch.user');
            Route::post('analytics/dashboard?admin=1', 'DashboardAnalyticsController@fetch')->name('analytics.fetch.admin');

        });

        Route::namespace('Profiles')->group(function() {

            /**
             * @Admin Profiles
             */
            Route::get('profile', 'ProfileController@show')->name('profiles.show');
            Route::post('profile/update', 'ProfileController@update')->name('profiles.update');
            Route::post('profile/change-password', 'ProfileController@changePassword')->name('profiles.change-password');

            Route::post('profile/fetch', 'ProfileController@fetch')->name('profiles.fetch');

        });

        /**
         * @AdminUsers
         */
        Route::namespace('AdminUsers')->group(function() {

            /**
             * @AdminUsers
             */
            Route::get('admin-users', 'AdminUserController@index')->name('admin-users.index');
            Route::get('admin-users/create', 'AdminUserController@create')->name('admin-users.create');
            Route::post('admin-users/store', 'AdminUserController@store')->name('admin-users.store');
            Route::get('admin-users/show/{id}', 'AdminUserController@show')->name('admin-users.show');
            Route::post('admin-users/update/{id}', 'AdminUserController@update')->name('admin-users.update');
            Route::post('admin-users/{id}/archive', 'AdminUserController@archive')->name('admin-users.archive');
            Route::post('admin-users/{id}/restore', 'AdminUserController@restore')->name('admin-users.restore');

            Route::post('admin-users/fetch', 'AdminUserFetchController@fetch')->name('admin-users.fetch');
            Route::post('admin-users/fetch?archived=1', 'AdminUserFetchController@fetch')->name('admin-users.fetch-archive');
            Route::post('admin-users/fetch-item/{id?}', 'AdminUserFetchController@fetchView')->name('admin-users.fetch-item');
            Route::post('admin-users/fetch-pagination/{id}', 'AdminUserFetchController@fetchPagePagination')->name('admin-users.fetch-pagination');

        });

        /**
         * @Users
         */
        Route::namespace('Users')->group(function() {

            /**
             * @AdminUsers
             */
            Route::get('users', 'UserController@index')->name('users.index');
            Route::get('users/create', 'UserController@create')->name('users.create');
            Route::post('users/store', 'UserController@store')->name('users.store');
            Route::get('users/show/{id}', 'UserController@show')->name('users.show');
            Route::post('users/update/{id}', 'UserController@update')->name('users.update');
            Route::post('users/{id}/archive', 'UserController@archive')->name('users.archive');
            Route::post('users/{id}/restore', 'UserController@restore')->name('users.restore');

            Route::post('users/fetch', 'UserFetchController@fetch')->name('users.fetch');
            Route::post('users/fetch?archived=1', 'UserFetchController@fetch')->name('users.fetch-archive');
            Route::post('users/fetch-item/{id?}', 'UserFetchController@fetchView')->name('users.fetch-item');
            Route::post('users/fetch-pagination/{id}', 'UserFetchController@fetchPagePagination')->name('users.fetch-pagination');

        });

        /**
         * CMS Pages
         */
        Route::namespace('Pages')->group(function() {

            Route::get('pages', 'PageController@index')->name('pages.index');
            Route::get('pages/create', 'PageController@create')->name('pages.create');
            Route::post('pages/store', 'PageController@store')->name('pages.store');
            Route::get('pages/show/{id}', 'PageController@show')->name('pages.show');
            Route::post('pages/update/{id}', 'PageController@update')->name('pages.update');
            Route::post('pages/{id}/archive', 'PageController@archive')->name('pages.archive');
            Route::post('pages/{id}/restore', 'PageController@restore')->name('pages.restore');

            Route::post('pages/fetch', 'PageFetchController@fetch')->name('pages.fetch');
            Route::post('pages/fetch?archived=1', 'PageFetchController@fetch')->name('pages.fetch-archive');
            Route::post('pages/fetch-item/{id?}', 'PageFetchController@fetchView')->name('pages.fetch-item');
            Route::post('pages/fetch-pagination/{id}', 'PageFetchController@fetchPagePagination')->name('pages.fetch-pagination');

            Route::get('page-items', 'PageItemController@index')->name('page-items.index');
            Route::get('page-items/create', 'PageItemController@create')->name('page-items.create');
            Route::post('page-items/store', 'PageItemController@store')->name('page-items.store');
            Route::get('page-items/show/{id}', 'PageItemController@show')->name('page-items.show');
            Route::post('page-items/update/{id}', 'PageItemController@update')->name('page-items.update');
            Route::post('page-items/{id}/archive', 'PageItemController@archive')->name('page-items.archive');
            Route::post('page-items/{id}/restore', 'PageItemController@restore')->name('page-items.restore');

            Route::post('page-items/fetch', 'PageItemFetchController@fetch')->name('page-items.fetch');
            Route::post('page-items/fetch?archived=1', 'PageItemFetchController@fetch')->name('page-items.fetch-archive');
            Route::post('page-items/fetch?page_id={id}', 'PageItemFetchController@fetch')->name('page-items.fetch-page-items');
            Route::post('page-items/fetch-item/{id?}', 'PageItemFetchController@fetchView')->name('page-items.fetch-item');
            Route::post('page-items/fetch-pagination/{id}', 'PageItemFetchController@fetchPagePagination')->name('page-items.fetch-pagination');

        });

        /**
         * Carousels
         */
        Route::namespace('Carousels')->group(function() {

            Route::get('home-banners', 'HomeBannerController@index')->name('home-banners.index');
            Route::get('home-banners/create', 'HomeBannerController@create')->name('home-banners.create');
            Route::post('home-banners/store', 'HomeBannerController@store')->name('home-banners.store');
            Route::get('home-banners/show/{id}', 'HomeBannerController@show')->name('home-banners.show');
            Route::post('home-banners/update/{id}', 'HomeBannerController@update')->name('home-banners.update');
            Route::post('home-banners/{id}/archive', 'HomeBannerController@archive')->name('home-banners.archive');
            Route::post('home-banners/{id}/restore', 'HomeBannerController@restore')->name('home-banners.restore');
            Route::post('home-banners/{id}/remove-image', 'HomeBannerController@removeImage')->name('home-banners.remove-image');

            Route::post('home-banners/fetch', 'HomeBannerFetchController@fetch')->name('home-banners.fetch');
            Route::post('home-banners/fetch?archived=1', 'HomeBannerFetchController@fetch')->name('home-banners.fetch-archive');
            Route::post('home-banners/fetch-item/{id?}', 'HomeBannerFetchController@fetchView')->name('home-banners.fetch-item');
            Route::post('home-banners/fetch-pagination/{id}', 'HomeBannerFetchController@fetchPagePagination')->name('home-banners.fetch-pagination');
        });

        /**
         * Tabbings
         */
        Route::namespace('Tabbings')->group(function() {

            Route::get('about-infos', 'AboutInfoController@index')->name('about-infos.index');
            Route::get('about-infos/create', 'AboutInfoController@create')->name('about-infos.create');
            Route::post('about-infos/store', 'AboutInfoController@store')->name('about-infos.store');
            Route::get('about-infos/show/{id}', 'AboutInfoController@show')->name('about-infos.show');
            Route::post('about-infos/update/{id}', 'AboutInfoController@update')->name('about-infos.update');
            Route::post('about-infos/{id}/archive', 'AboutInfoController@archive')->name('about-infos.archive');
            Route::post('about-infos/{id}/restore', 'AboutInfoController@restore')->name('about-infos.restore');
            Route::post('about-infos/{id}/remove-image', 'AboutInfoController@removeImage')->name('about-infos.remove-image');

            Route::post('about-infos/fetch', 'AboutInfoFetchController@fetch')->name('about-infos.fetch');
            Route::post('about-infos/fetch?archived=1', 'AboutInfoFetchController@fetch')->name('about-infos.fetch-archive');
            Route::post('about-infos/fetch-item/{id?}', 'AboutInfoFetchController@fetchView')->name('about-infos.fetch-item');
            Route::post('about-infos/fetch-pagination/{id}', 'AboutInfoFetchController@fetchPagePagination')->name('about-infos.fetch-pagination');
        });

        /**
         * @Roles
         */
        Route::namespace('Roles')->group(function() {

            Route::get('roles', 'RoleController@index')->name('roles.index');
            Route::get('roles/create', 'RoleController@create')->name('roles.create');
            Route::post('roles/store', 'RoleController@store')->name('roles.store');
            Route::get('roles/{id}', 'RoleController@show')->name('roles.show');
            Route::post('roles/{id}/update', 'RoleController@update')->name('roles.update');
            Route::post('roles/{id}/archive', 'RoleController@archive')->name('roles.archive');
            Route::post('roles/{id}/restore', 'RoleController@restore')->name('roles.restore');

            Route::post('roles/{id}/update-permission', 'RoleController@updatePermissions')->name('roles.update-permissions');

            Route::post('roles/fetch', 'RoleFetchController@fetch')->name('roles.fetch');
            Route::post('roles/fetch?archived=1', 'RoleFetchController@fetch')->name('roles.fetch-archive');
            Route::post('roles/fetch-item/{id?}', 'RoleFetchController@fetchView')->name('roles.fetch-item');
            Route::post('role/fetch-pagination/{id}', 'RoleFetchController@fetchPagePagination')->name('roles.fetch-pagination');

        });

        /**
         * @Permissions
         */
        Route::namespace('Permissions')->group(function() {

            Route::post('permissions-fetch/{id?}', 'PermissionFetchController@fetch')->name('permissions.fetch');

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

            Route::post('activity-logs/fetch?id={id?}&sample=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.sample-items');

            Route::post('activity-logs/fetch?id={id?}&admin=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.admin-users');
            Route::post('activity-logs/fetch?id={id?}&user=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.users');

            Route::post('activity-logs/fetch?profile=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.profiles');

            Route::post('activity-logs/fetch?id={id?}&roles=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.roles');

            Route::post('activity-logs/fetch?id={id?}&pagecontents=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.pages');
            Route::post('activity-logs/fetch?id={id?}&pageitems=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.page-items');

            Route::post('activity-logs/fetch?id={id?}&articles=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.articles');

            Route::post('activity-logs/fetch?id={id?}&home-banners=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.home-banners');

            Route::post('activity-logs/fetch?id={id?}&about-infos=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.about-infos');

            Route::post('activity-logs/fetch?id={id?}&destinations=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.destinations');

            Route::post('activity-logs/fetch?id={id?}&inquiries=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.inquiries');

            Route::post('activity-logs/fetch?id={id?}&experiences=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.experiences');

            Route::post('activity-logs/fetch?id={id?}&annual_incomes=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.annual_incomes');

            Route::post('activity-logs/fetch?id={id?}&survey-experiences=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.survey-experiences');

            Route::post('activity-logs/fetch?id={id?}&add-ons=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.add-ons');

            Route::post('activity-logs/fetch?id={id?}&visitor-types=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.visitor-types');
            
            Route::post('activity-logs/fetch?id={id?}&allocations=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.allocations');

            Route::post('activity-logs/fetch?id={id?}&fees=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.fees');

            Route::post('activity-logs/fetch?id={id?}&feedbacks=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.feedbacks');

            Route::post('activity-logs/fetch?id={id?}&blocked-dates=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.blocked-dates');

            Route::post('activity-logs/fetch?id={id?}&managements=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.managements');

            Route::post('activity-logs/fetch?id={id?}&training-modules=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.training-modules');

            Route::post('activity-logs/fetch?id={id?}&faqs=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.faqs');

            Route::post('activity-logs/fetch?id={id?}&capacities=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.capacities');

            Route::post('activity-logs/fetch?id={id?}&agencies=1', 'ActivityLogFetchController@fetch')->name('activity-logs.fetch.agencies');

        });

        Route::namespace('Articles')->group(function() {
            Route::get('articles', 'ArticleController@index')->name('articles.index');
            Route::get('articles/create', 'ArticleController@create')->name('articles.create');
            Route::post('articles/store', 'ArticleController@store')->name('articles.store');
            Route::get('articles/show/{id}', 'ArticleController@show')->name('articles.show');
            Route::post('articles/update/{id}', 'ArticleController@update')->name('articles.update');
            Route::post('articles/{id}/archive', 'ArticleController@archive')->name('articles.archive');
            Route::post('articles/{id}/restore', 'ArticleController@restore')->name('articles.restore');
            Route::post('articles/{id}/remove-image', 'ArticleController@removeImage')->name('articles.remove-image');

            Route::post('articles/fetch', 'ArticleFetchController@fetch')->name('articles.fetch');
            Route::post('articles/fetch?archived=1', 'ArticleFetchController@fetch')->name('articles.fetch-archive');
            Route::post('articles/fetch-item/{id?}', 'ArticleFetchController@fetchView')->name('articles.fetch-item');
            Route::post('articles/fetch-pagination/{id}', 'ArticleFetchController@fetchPagePagination')->name('articles.fetch-pagination');
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

            Route::post('sample-items/export', 'SampleItemController@export')->name('sample-items.export');

            Route::post('sample-items/{id}/approve', 'SampleItemController@approve')->name('sample-items.approve');
            Route::post('sample-items/{id}/deny', 'SampleItemController@deny')->name('sample-items.deny');

            Route::post('sample-items/fetch', 'SampleItemFetchController@fetch')->name('sample-items.fetch');
            Route::post('sample-items/fetch?archived=1', 'SampleItemFetchController@fetch')->name('sample-items.fetch-archive');
            Route::post('sample-items/fetch-item/{id?}', 'SampleItemFetchController@fetchView')->name('sample-items.fetch-item');
            Route::post('sample-items/fetch-pagination/{id}', 'SampleItemFetchController@fetchPagePagination')->name('sample-items.fetch-pagination');
        });

        Route::namespace('Destinations')->group(function() {
            Route::get('destinations', 'DestinationController@index')->name('destinations.index');
            Route::get('destinations/create', 'DestinationController@create')->name('destinations.create');
            Route::post('destinations/store', 'DestinationController@store')->name('destinations.store');
            Route::get('destinations/show/{id}', 'DestinationController@show')->name('destinations.show');
            Route::post('destinations/update/{id}', 'DestinationController@update')->name('destinations.update');
            Route::post('destinations/{id}/archive', 'DestinationController@archive')->name('destinations.archive');
            Route::post('destinations/{id}/restore', 'DestinationController@restore')->name('destinations.restore');
            Route::post('destinations/{id}/remove-image', 'DestinationController@removeImage')->name('destinations.remove-image');

            Route::post('destinations/fetch', 'DestinationFetchController@fetch')->name('destinations.fetch');
            Route::post('destinations/fetch?archived=1', 'DestinationFetchController@fetch')->name('destinations.fetch-archive');
            Route::post('destinations/fetch-item/{id?}', 'DestinationFetchController@fetchView')->name('destinations.fetch-item');
            Route::post('destinations/fetch-pagination/{id}', 'DestinationFetchController@fetchPagePagination')->name('destinations.fetch-pagination');
        });

        Route::namespace('Inquiries')->group(function() {
            Route::get('inquiries', 'InquiryController@index')->name('inquiries.index');
            Route::get('inquiries/show/{id}', 'InquiryController@show')->name('inquiries.show');
            Route::post('inquiries/{id}/archive', 'InquiryController@archive')->name('inquiries.archive');
            Route::post('inquiries/{id}/restore', 'InquiryController@restore')->name('inquiries.restore');

            Route::post('inquiries/fetch', 'InquiryFetchController@fetch')->name('inquiries.fetch');
            Route::post('inquiries/fetch?archived=1', 'InquiryFetchController@fetch')->name('inquiries.fetch-archive');
            Route::post('inquiries/fetch-item/{id?}', 'InquiryFetchController@fetchView')->name('inquiries.fetch-item');
            Route::post('inquiries/fetch-pagination/{id}', 'InquiryFetchController@fetchPagePagination')->name('inquiries.fetch-pagination');
        });


        Route::namespace('Experiences')->group(function() {
            Route::get('experiences', 'ExperienceController@index')->name('experiences.index');
            Route::get('experiences/create', 'ExperienceController@create')->name('experiences.create');
            Route::post('experiences/store', 'ExperienceController@store')->name('experiences.store');
            Route::get('experiences/show/{id}', 'ExperienceController@show')->name('experiences.show');
            Route::post('experiences/update/{id}', 'ExperienceController@update')->name('experiences.update');
            Route::post('experiences/{id}/archive', 'ExperienceController@archive')->name('experiences.archive');
            Route::post('experiences/{id}/restore', 'ExperienceController@restore')->name('experiences.restore');
        
            Route::post('experiences/fetch', 'ExperienceFetchController@fetch')->name('experiences.fetch');
            Route::post('experiences/fetch?archived=1', 'ExperienceFetchController@fetch')->name('experiences.fetch-archive');
            Route::post('experiences/fetch-item/{id?}', 'ExperienceFetchController@fetchView')->name('experiences.fetch-item');
            Route::post('experiences/fetch-pagination/{id}', 'ExperienceFetchController@fetchPagePagination')->name('experiences.fetch-pagination');
        });

        Route::namespace('AnnualIncomes')->group(function() {
            Route::get('annual_incomes', 'AnnualIncomeController@index')->name('annual_incomes.index');
            Route::get('annual_incomes/create', 'AnnualIncomeController@create')->name('annual_incomes.create');
            Route::post('annual_incomes/store', 'AnnualIncomeController@store')->name('annual_incomes.store');
            Route::get('annual_incomes/show/{id}', 'AnnualIncomeController@show')->name('annual_incomes.show');
            Route::post('annual_incomes/update/{id}', 'AnnualIncomeController@update')->name('annual_incomes.update');
            Route::post('annual_incomes/{id}/archive', 'AnnualIncomeController@archive')->name('annual_incomes.archive');
            Route::post('annual_incomes/{id}/restore', 'AnnualIncomeController@restore')->name('annual_incomes.restore');
            Route::post('annual_incomes/reorder', 'AnnualIncomeController@reOrder')->name('annual_incomes.reorder');
        
            Route::post('annual_incomes/fetch', 'AnnualIncomeFetchController@fetch')->name('annual_incomes.fetch');
            Route::post('annual_incomes/fetch?archived=1', 'AnnualIncomeFetchController@fetch')->name('annual_incomes.fetch-archive');
            Route::post('annual_incomes/fetch-item/{id?}', 'AnnualIncomeFetchController@fetchView')->name('annual_incomes.fetch-item');
            Route::post('annual_incomes/fetch-pagination/{id}', 'AnnualIncomeFetchController@fetchPagePagination')->name('annual_incomes.fetch-pagination');
        });

        Route::namespace('SurveyExperiences')->group(function() {
            Route::get('survey-experiences', 'SurveyExperienceController@index')->name('survey-experiences.index');
            Route::get('survey-experiences/create', 'SurveyExperienceController@create')->name('survey-experiences.create');
            Route::post('survey-experiences/store', 'SurveyExperienceController@store')->name('survey-experiences.store');
            Route::get('survey-experiences/show/{id}', 'SurveyExperienceController@show')->name('survey-experiences.show');
            Route::post('survey-experiences/update/{id}', 'SurveyExperienceController@update')->name('survey-experiences.update');
            Route::post('survey-experiences/{id}/archive', 'SurveyExperienceController@archive')->name('survey-experiences.archive');
            Route::post('survey-experiences/{id}/restore', 'SurveyExperienceController@restore')->name('survey-experiences.restore');
            Route::post('survey-experiences/reorder', 'SurveyExperienceController@reOrder')->name('survey-experiences.reorder');
        
            Route::post('survey-experiences/fetch', 'SurveyExperienceFetchController@fetch')->name('survey-experiences.fetch');
            Route::post('survey-experiences/fetch?archived=1', 'SurveyExperienceFetchController@fetch')->name('survey-experiences.fetch-archive');
            Route::post('survey-experiences/fetch-item/{id?}', 'SurveyExperienceFetchController@fetchView')->name('survey-experiences.fetch-item');
            Route::post('survey-experiences/fetch-pagination/{id}', 'SurveyExperienceFetchController@fetchPagePagination')->name('survey-experiences.fetch-pagination');
        });

        Route::namespace('Allocations')->group(function() {
            Route::get('allocations', 'AllocationController@index')->name('allocations.index');
            Route::get('allocations/create', 'AllocationController@create')->name('allocations.create');
            Route::post('allocations/store', 'AllocationController@store')->name('allocations.store');
            Route::get('allocations/show/{id}', 'AllocationController@show')->name('allocations.show');
            Route::post('allocations/update/{id}', 'AllocationController@update')->name('allocations.update');
            Route::post('allocations/{id}/archive', 'AllocationController@archive')->name('allocations.archive');
            Route::post('allocations/{id}/restore', 'AllocationController@restore')->name('allocations.restore');
        
            Route::post('allocations/fetch', 'AllocationFetchController@fetch')->name('allocations.fetch');
            Route::post('allocations/fetch?archived=1', 'AllocationFetchController@fetch')->name('allocations.fetch-archive');
            Route::post('allocations/fetch-item/{id?}', 'AllocationFetchController@fetchView')->name('allocations.fetch-item');
            Route::post('allocations/fetch-pagination/{id}', 'AllocationFetchController@fetchPagePagination')->name('allocations.fetch-pagination');
        });

        Route::namespace('AddOns')->group(function() {
            Route::get('add-ons', 'AddOnController@index')->name('add-ons.index');
            Route::get('add-ons/create', 'AddOnController@create')->name('add-ons.create');
            Route::post('add-ons/store', 'AddOnController@store')->name('add-ons.store');
            Route::get('add-ons/show/{id}', 'AddOnController@show')->name('add-ons.show');
            Route::post('add-ons/update/{id}', 'AddOnController@update')->name('add-ons.update');
            Route::post('add-ons/{id}/archive', 'AddOnController@archive')->name('add-ons.archive');
            Route::post('add-ons/{id}/restore', 'AddOnController@restore')->name('add-ons.restore');
        
            Route::post('add-ons/fetch', 'AddOnFetchController@fetch')->name('add-ons.fetch');
            Route::post('add-ons/fetch?archived=1', 'AddOnFetchController@fetch')->name('add-ons.fetch-archive');
            Route::post('add-ons/fetch-item/{id?}', 'AddOnFetchController@fetchView')->name('add-ons.fetch-item');
            Route::post('add-ons/fetch-pagination/{id}', 'AddOnFetchController@fetchPagePagination')->name('add-ons.fetch-pagination');
        });

        Route::namespace('VisitorTypes')->group(function() {
            Route::get('visitor-types', 'VisitorTypeController@index')->name('visitor-types.index');
            Route::get('visitor-types/create', 'VisitorTypeController@create')->name('visitor-types.create');
            Route::post('visitor-types/store', 'VisitorTypeController@store')->name('visitor-types.store');
            Route::get('visitor-types/show/{id}', 'VisitorTypeController@show')->name('visitor-types.show');
            Route::post('visitor-types/update/{id}', 'VisitorTypeController@update')->name('visitor-types.update');
            Route::post('visitor-types/{id}/archive', 'VisitorTypeController@archive')->name('visitor-types.archive');
            Route::post('visitor-types/{id}/restore', 'VisitorTypeController@restore')->name('visitor-types.restore');
        
            Route::post('visitor-types/fetch', 'VisitorTypeFetchController@fetch')->name('visitor-types.fetch');
            Route::post('visitor-types/fetch?archived=1', 'VisitorTypeFetchController@fetch')->name('visitor-types.fetch-archive');
            Route::post('visitor-types/fetch-item/{id?}', 'VisitorTypeFetchController@fetchView')->name('visitor-types.fetch-item');
            Route::post('visitor-types/fetch-pagination/{id}', 'VisitorTypeFetchController@fetchPagePagination')->name('visitor-types.fetch-pagination');
        });

        Route::namespace('Calendars')->group(function() {
            Route::get('calendar', 'CalendarController@index')->name('calendar.index');
            Route::post('calendar/bookings', 'CalendarController@getBookings')->name('calendar.getBookings');
            
            Route::post('calendar/fetch', 'CalendarFetchController@fetch')->name('calendar.fetch');
        });

        Route::namespace('Books')->group(function() {
            Route::get('bookings/{selectedDate?}/{destination?}/{experience?}/{destination_name?}', 'BookController@index')->name('bookings.index');
            Route::get('bookings/create/{selectedDate?}/{destination?}/{experience?}/{destination_name?}', 'BookController@create')->name('bookings.create');
            Route::post('bookings/store/{selectedDate?}/{destination?}/{experience?}/{destination_name?}', 'BookController@store')->name('bookings.store');
            Route::get('bookings/show/{id}/{selectedDate?}/{destination?}/{experience?}/{destination_name?}', 'BookController@show')->name('bookings.show');
            Route::post('bookings/update/{id}/{selectedDate?}/{destination?}/{experience?}/{destination_name?}', 'BookController@update')->name('bookings.update');
            Route::post('bookings/{id}/archive', 'BookController@archive')->name('bookings.archive');
            Route::post('bookings/{id}/restore', 'BookController@restore')->name('bookings.restore');
        
            Route::post('bookings/fetch/{selectedDate?}/{destination?}/{experience?}', 'BookFetchController@fetch')->name('bookings.fetch');
            Route::post('bookings/fetch?archived=1', 'BookFetchController@fetch')->name('bookings.fetch-archive');
            Route::post('bookings/fetch-item/{id?}/{destination?}/{experience?}', 'BookFetchController@fetchView')->name('bookings.fetch-item');
            Route::post('bookings/fetch-pagination/{id}', 'BookFetchController@fetchPagePagination')->name('bookings.fetch-pagination');
        });

        Route::namespace('Fees')->group(function() {
            Route::get('fees', 'FeesController@index')->name('fees.index');
            Route::get('fees/create', 'FeesController@create')->name('fees.create');
            Route::post('fees/store', 'FeesController@store')->name('fees.store');
            Route::get('fees/show/{id}', 'FeesController@show')->name('fees.show');
            Route::post('fees/update/{id}', 'FeesController@update')->name('fees.update');
            Route::post('fees/{id}/archive', 'FeesController@archive')->name('fees.archive');
            Route::post('fees/{id}/restore', 'FeesController@restore')->name('fees.restore');
        
            Route::post('fees/fetch', 'FeesFetchController@fetch')->name('fees.fetch');
            Route::post('fees/fetch?archived=1', 'FeesFetchController@fetch')->name('fees.fetch-archive');
            Route::post('fees/fetch-item/{id?}', 'FeesFetchController@fetchView')->name('fees.fetch-item');
            Route::post('fees/fetch-pagination/{id}', 'FeesFetchController@fetchPagePagination')->name('fees.fetch-pagination');
        });

        Route::namespace('BlockedDates')->group(function() {
            Route::get('blocked-dates', 'BlockedDateController@index')->name('blocked-dates.index');
            Route::get('blocked-dates/create', 'BlockedDateController@create')->name('blocked-dates.create');
            Route::post('blocked-dates/store', 'BlockedDateController@store')->name('blocked-dates.store');
            Route::get('blocked-dates/show/{id}', 'BlockedDateController@show')->name('blocked-dates.show');
            Route::post('blocked-dates/update/{id}', 'BlockedDateController@update')->name('blocked-dates.update');
            Route::post('blocked-dates/{id}/archive', 'BlockedDateController@archive')->name('blocked-dates.archive');
            Route::post('blocked-dates/{id}/restore', 'BlockedDateController@restore')->name('blocked-dates.restore');
        
            Route::post('blocked-dates/fetch', 'BlockedDateFetchController@fetch')->name('blocked-dates.fetch');
            Route::post('blocked-dates/fetch?archived=1', 'BlockedDateFetchController@fetch')->name('blocked-dates.fetch-archive');
            Route::post('blocked-dates/fetch-item/{id?}', 'BlockedDateFetchController@fetchView')->name('blocked-dates.fetch-item');
            Route::post('blocked-dates/fetch-pagination/{id}', 'BlockedDateFetchController@fetchPagePagination')->name('blocked-dates.fetch-pagination');
        });


        Route::namespace('Feedbacks')->group(function() {
            Route::get('feedbacks', 'FeedbackController@index')->name('feedbacks.index');
            Route::get('feedbacks/create', 'FeedbackController@create')->name('feedbacks.create');
            Route::post('feedbacks/store', 'FeedbackController@store')->name('feedbacks.store');
            Route::get('feedbacks/show/{id}', 'FeedbackController@show')->name('feedbacks.show');
            Route::post('feedbacks/update/{id}', 'FeedbackController@update')->name('feedbacks.update');
            Route::post('feedbacks/{id}/archive', 'FeedbackController@archive')->name('feedbacks.archive');
            Route::post('feedbacks/{id}/restore', 'FeedbackController@restore')->name('feedbacks.restore');
             Route::post('feedbacks/reorder', 'FeedbackController@reOrder')->name('feedbacks.reorder');
        
            Route::post('feedbacks/fetch', 'FeedbackFetchController@fetch')->name('feedbacks.fetch');
            Route::post('feedbacks/fetch?archived=1', 'FeedbackFetchController@fetch')->name('feedbacks.fetch-archive');
            Route::post('feedbacks/fetch-item/{id?}', 'FeedbackFetchController@fetchView')->name('feedbacks.fetch-item');
            Route::post('feedbacks/fetch-pagination/{id}', 'FeedbackFetchController@fetchPagePagination')->name('feedbacks.fetch-pagination');
        });

        Route::namespace('Managements')->group(function() {
            Route::get('managements', 'ManagementController@index')->name('managements.index');
            Route::get('managements/create', 'ManagementController@create')->name('managements.create');
            Route::post('managements/store', 'ManagementController@store')->name('managements.store');
            Route::get('managements/show/{id}', 'ManagementController@show')->name('managements.show');
            Route::post('managements/update/{id}', 'ManagementController@update')->name('managements.update');
            Route::post('managements/{id}/archive', 'ManagementController@archive')->name('managements.archive');
            Route::post('managements/{id}/restore', 'ManagementController@restore')->name('managements.restore');
        
            Route::post('managements/fetch', 'ManagementFetchController@fetch')->name('managements.fetch');
            Route::post('managements/fetch?archived=1', 'ManagementFetchController@fetch')->name('managements.fetch-archive');
            Route::post('managements/fetch-item/{id?}', 'ManagementFetchController@fetchView')->name('managements.fetch-item');
            Route::post('managements/fetch-pagination/{id}', 'ManagementFetchController@fetchPagePagination')->name('managements.fetch-pagination');
        });

        Route::namespace('TrainingModules')->group(function() {
            Route::get('training-modules', 'TrainingModuleController@index')->name('training-modules.index');
            Route::get('training-modules/create', 'TrainingModuleController@create')->name('training-modules.create');
            Route::post('training-modules/store', 'TrainingModuleController@store')->name('training-modules.store');
            Route::get('training-modules/show/{id}', 'TrainingModuleController@show')->name('training-modules.show');
            Route::post('training-modules/update/{id}', 'TrainingModuleController@update')->name('training-modules.update');
            Route::post('training-modules/{id}/archive', 'TrainingModuleController@archive')->name('training-modules.archive');
            Route::post('training-modules/{id}/restore', 'TrainingModuleController@restore')->name('training-modules.restore');
        
            Route::post('training-modules/fetch', 'TrainingModuleFetchController@fetch')->name('training-modules.fetch');
            Route::post('training-modules/fetch?archived=1', 'TrainingModuleFetchController@fetch')->name('training-modules.fetch-archive');
            Route::post('training-modules/fetch-item/{id?}', 'TrainingModuleFetchController@fetchView')->name('training-modules.fetch-item');
            Route::post('training-modules/fetch-pagination/{id}', 'TrainingModuleFetchController@fetchPagePagination')->name('training-modules.fetch-pagination');
        });

        Route::namespace('Faqs')->group(function() {
            Route::get('faqs', 'FaqController@index')->name('faqs.index');
            Route::get('faqs/create', 'FaqController@create')->name('faqs.create');
            Route::post('faqs/store', 'FaqController@store')->name('faqs.store');
            Route::get('faqs/show/{id}', 'FaqController@show')->name('faqs.show');
            Route::post('faqs/update/{id}', 'FaqController@update')->name('faqs.update');
            Route::post('faqs/{id}/archive', 'FaqController@archive')->name('faqs.archive');
            Route::post('faqs/{id}/restore', 'FaqController@restore')->name('faqs.restore');
        
            Route::post('faqs/fetch', 'FaqFetchController@fetch')->name('faqs.fetch');
            Route::post('faqs/fetch?archived=1', 'FaqFetchController@fetch')->name('faqs.fetch-archive');
            Route::post('faqs/fetch-item/{id?}', 'FaqFetchController@fetchView')->name('faqs.fetch-item');
            Route::post('faqs/fetch-pagination/{id}', 'FaqFetchController@fetchPagePagination')->name('faqs.fetch-pagination');
        });

        Route::namespace('Capacities')->group(function() {
            Route::get('capacities', 'CapacityController@index')->name('capacities.index');
            Route::get('capacities/create', 'CapacityController@create')->name('capacities.create');
            Route::post('capacities/store', 'CapacityController@store')->name('capacities.store');
            Route::get('capacities/show/{id}', 'CapacityController@show')->name('capacities.show');
            Route::post('capacities/update/{id}', 'CapacityController@update')->name('capacities.update');
            Route::post('capacities/{id}/archive', 'CapacityController@archive')->name('capacities.archive');
            Route::post('capacities/{id}/restore', 'CapacityController@restore')->name('capacities.restore');
        
            Route::post('capacities/fetch', 'CapacityFetchController@fetch')->name('capacities.fetch');
            Route::post('capacities/fetch?archived=1', 'CapacityFetchController@fetch')->name('capacities.fetch-archive');
            Route::post('capacities/fetch-item/{id?}', 'CapacityFetchController@fetchView')->name('capacities.fetch-item');
            Route::post('capacities/fetch-pagination/{id}', 'CapacityFetchController@fetchPagePagination')->name('capacities.fetch-pagination');
        });

        Route::namespace('Agencies')->group(function() {
            Route::get('agencies', 'AgencyController@index')->name('agencies.index');
            Route::get('agencies/create', 'AgencyController@create')->name('agencies.create');
            Route::post('agencies/store', 'AgencyController@store')->name('agencies.store');
            Route::get('agencies/show/{id}', 'AgencyController@show')->name('agencies.show');
            Route::post('agencies/update/{id}', 'AgencyController@update')->name('agencies.update');
            Route::post('agencies/{id}/archive', 'AgencyController@archive')->name('agencies.archive');
            Route::post('agencies/{id}/restore', 'AgencyController@restore')->name('agencies.restore');
        
            Route::post('agencies/fetch', 'AgencyFetchController@fetch')->name('agencies.fetch');
            Route::post('agencies/fetch?archived=1', 'AgencyFetchController@fetch')->name('agencies.fetch-archive');
            Route::post('agencies/fetch-item/{id?}', 'AgencyFetchController@fetchView')->name('agencies.fetch-item');
            Route::post('agencies/fetch-pagination/{id}', 'AgencyFetchController@fetchPagePagination')->name('agencies.fetch-pagination');
        });

    });
});