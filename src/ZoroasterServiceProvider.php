<?php

namespace KarimQaderi\Zoroaster;

use Illuminate\Support\ServiceProvider;

class ZoroasterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }

        $this->registerResources();

    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {

        $this->publishes([
            __DIR__.'/../config/Zoroaster.php' => config_path('Zoroaster.php'),
        ], 'Zoroaster-config');

        $this->publishes([
            __DIR__.'/../publishable' => public_path('vendor/Zoroaster'),
        ], 'Zoroaster-assets');

//        $this->publishes([
//            __DIR__.'/../resources/lang' => resource_path('lang/vendor/Zoroaster'),
//        ], 'Zoroaster-lang');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/Zoroaster'),
        ], 'Zoroaster-views');

        $this->publishes([
            __DIR__.'/../database' => database_path(),
        ], 'Zoroaster-migrations');
    }

    /**
     * Register the package resources such as routes, templates, etc.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'Zoroaster');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'Zoroaster');
        $this->loadJsonTranslationsFrom(resource_path('lang/vendor/Zoroaster'));


            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');


        $this->registerRoutes();
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
//        Route::group($this->routeConfiguration(), function () {
//            $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');
//        });
    }

    /**
     * Get the Zoroaster route group configuration array.
     *
     * @return array
     */
    protected function routeConfiguration()
    {
        return [
            'namespace' => 'KarimQaderi\Zoroaster\Http\Controllers',
            'domain' => config('Zoroaster.domain', null),
            'as' => 'Zoroaster.web.',
            'prefix' => 'Zoroaster-web',
            'middleware' => 'Zoroaster',
        ];
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            Console\InstallCommand::class,
            Console\PublishCommand::class,
            Console\ResourceCommand::class,
            Console\CreateAdminCommand::class,
        ]);
    }
}
