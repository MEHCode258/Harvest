<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\HarvestService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(HarvestService::class, function ($app) {
            return new HarvestService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
