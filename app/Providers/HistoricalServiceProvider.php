<?php

namespace App\Providers;

use App\Services\HistoricalTimeFrameService;
use Illuminate\Support\ServiceProvider;

class HistoricalServiceProvider extends ServiceProvider {
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton(HistoricalTimeFrameService::class, function ($app) {
            return new HistoricalTimeFrameService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        //
    }
}
