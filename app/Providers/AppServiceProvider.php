<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);

        Paginator::useBootstrapFour();

        $ip = request()->ip();
       if($ip == '127.0.0.1') {
        $ip = '213.6.167.51';
       }

       $country = Http::get('http://www.geoplugin.net/json.gp?ip='.$ip)->json();

    //    dd($country);

        $weather = Http::get('https://api.openweathermap.org/data/2.5/weather?q='.$country['geoplugin_regionName'].'&appid=dccab945679f3bb9019537a309e05e47&units=metric')->json();

    //    dd(request()->ip());



        // dd($weather);

        View::share('weather', $weather);
    }
}
