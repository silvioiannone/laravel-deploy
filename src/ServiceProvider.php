<?php

namespace SilvioIannone\LaravelDeploy;

use \Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use SilvioIannone\LaravelDeploy\Commands\Deploy;

/**
 * Laravel-deploy service provider.
 */
class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/deploy.php' => config_path('deploy.php')
        ]);
        
        $this->registerArtisanCommands();
    }
    
    /**
     * Register the package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/deploy.php', 'deploy');
    }
    
    /**
     * Register the Artisan commands made available by the package.
     */
    protected function registerArtisanCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Deploy::class
            ]);
        }
    }
}
