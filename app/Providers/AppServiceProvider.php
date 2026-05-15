<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Models\SiteConfiguration;
use App\Models\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        if(env('APP_ENV') != 'local'){
            \URL::forceScheme('https');
        }

        View::composer('_layouts._dashboard', function($view) {
            return $view->with('config', SiteConfiguration::from_cache());
        });


        View::composer('_layouts._book-dashboard', function($view) {
            return $view->with('config', SiteConfiguration::from_cache())
                            ->with('event', Event::event());
        });

        View::composer('_layouts._exec-dashboard', function($view) {
            return $view->with('config', SiteConfiguration::from_cache());
        });

        View::composer('_layouts._leaderboard-dashboard', function($view) {
            return $view->with('config', SiteConfiguration::from_cache());
        });

        View::composer('_layouts._login', function($view) {
            return $view->with('config', SiteConfiguration::from_cache());
        });

        View::composer('book.auth.reset-code', function($view) {
            return $view->with('config', SiteConfiguration::from_cache());
        });

        View::composer('_layouts._book-login', function($view) {
            return $view->with('config', SiteConfiguration::from_cache());
        });



    }
}
