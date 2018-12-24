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
            Console\PermissionCommand::class,
        ]);
    }
}
