<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RideHistoryService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Registrar el RideHistoryService
        $this->app->singleton(RideHistoryService::class, function ($app) {
            return new RideHistoryService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
