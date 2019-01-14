<?php

namespace Therilion\Timerizable;

use Illuminate\Support\ServiceProvider;

class TimerizableServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/', 'timerizable');

        // Publishes translations
        $this->publishes([
            __DIR__.'/../resources/lang/' => resource_path('lang/vendor/timerizable'),
        ], 'translations');

        $this->publishes([
            __DIR__.'/../config/timerizable.php' => config_path('timerizable.php'),
        ], 'config');

        // Publishes migrations
        $this->publishes([
            __DIR__.'/../database/migrations/create_time_blocks_table.php' => database_path('migrations'). '/' . now()->format('Y_m_d_his') . '_create_time_blocks_table.php',
            __DIR__.'/../database/migrations/create_time_intervals_table.php' => database_path('migrations'). '/' . now()->format('Y_m_d_his') . '_create_time_intervals_table.php',
        ], 'migrations');

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // Register the service the package provides.
        $this->app->singleton('timerizable', function ($app) {
            return new Timerizable;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['timerizable'];
    }
    
}
