<?php

namespace App\Providers;

use App\Models\Business;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        if (env('APP_ENV') === 'produccion') {
            URL::forceScheme('https');
        }

        view()->composer('*',function($view){
            if(auth()->check()){
                $business = Business::getBusiness();

            $view->with(compact('business'));
            }
        });
    }
}
