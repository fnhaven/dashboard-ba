<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Services\Adapter\GuzzleHttpAdapter;
use App\Services\Payment\Payment;

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

        $this->app->singleton('App\Services\Payment\Payment', function ($app) {
            return new Payment(new GuzzleHttpAdapter(), config('midtrans.endpoint'));
        });
    }
}
