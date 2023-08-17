<?php

namespace App\Providers;

use App\Models\Abonent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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
        view()->composer('*', function($view)
        {
            if (Auth::check()) {
                $isAbonent = Abonent::where('user_id', Auth::id())->count() > 0;
                $view->with('isAbonent', $isAbonent);
            }else {
                $view->with('isAbonent', false);
            }
        });
    }
}
