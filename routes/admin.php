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
            Route::post('destinations/{id}/remove-image', 'DestinationController@removeImage')->name('destinations.remove-image');

            Route::post('destinations/fetch', 'DestinationFetchController@fetch')->name('destinations.fetch');
        });
    });
});