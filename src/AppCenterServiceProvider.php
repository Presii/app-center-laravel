<?php
namespace Presi\AppCenter;

use Illuminate\Support\ServiceProvider;

class AppCenterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/appcenter.php';
        $this->publishes([$configPath => config_path('appcenter.php')], 'config');
        $this->mergeConfigFrom($configPath, 'appcenter');
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('appcenter', function ($app) {
        
        $config = $app['config']['appcenter'] ?: $app['config']['appcenter::config'];

        $client = new AppCenterClient($config['api_token'], $config['owner_name']);
        
            return $client;
        });
    }
    
    public function provides() {
        return ['appcenter'];
    }
}