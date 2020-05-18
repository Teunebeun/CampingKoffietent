<?php

namespace App\Providers;

use App\FooterLink;
use Illuminate\Support\ServiceProvider;
use App\SingularItems;
use Carbon\Carbon;

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
        Carbon::setLocale('en');
         view()->composer('*', function($view) {
            $view->with('infoFooter', SingularItems::first())
                 ->with('otherLinks', FooterLink::all());
         });
    }
}
