<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;

use Auth;
use Carbon\Carbon;

use App\Helpers\AuthHelpers;
use App\Helpers\EnvHelpers;
use App\Helpers\GlobalChecker;

use App\Models\Pages\PageItem;
use App\Models\Books\Book;
use App\Observers\BookingObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);

        if (config('web.force_https')) {
            URL::forceScheme('https');
        }

        View::composer('*', function ($view) {

            View::share('self', new AuthHelpers);
            
            View::share('checker', new GlobalChecker);
            View::share('env', new EnvHelpers);
        });

        View::composer('web.partials.footer', function($view) {
            $twitter = PageItem::where('slug', 'twitter')->first();
            $fb = PageItem::where('slug', 'facebook')->first();
            $insta = PageItem::where('slug', 'instagram')->first();
            $youtube = PageItem::where('slug', 'youtube')->first();
            $view->with('fb', $fb);
            $view->with('twitter', $twitter);
            $view->with('insta', $insta);
            $view->with('youtube', $youtube);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Book::observe(BookingObserver::class);
    }
}
