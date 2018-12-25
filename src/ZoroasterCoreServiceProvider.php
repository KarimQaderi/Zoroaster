<?php

    namespace KarimQaderi\Zoroaster;

    use Illuminate\Support\Facades\Gate;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\ServiceProvider;

    class ZoroasterCoreServiceProvider extends ServiceProvider
    {
        /**
         * Bootstrap any package services.
         *
         * @return void
         */
        public function boot()
        {
            $this->app->register(ZoroasterServiceProvider::class);

            if(!$this->app->configurationIsCached())
            {
                $this->mergeConfigFrom(__DIR__ . '/../config/Zoroaster.php' , 'Zoroaster');
            }

            Route::middlewareGroup('Zoroaster' , config('Zoroaster.middleware' , []));


            if($this->app->runningInConsole())
            {
                $this->registerPublishing();
            }

            
            $this->registerResources();

            $this->Gates();

        }

        /**
         * Register any application services.
         *
         * @return void
         */
        public function register()
        {
            $this->Helpers();

            $this->commands([
                Console\InstallCommand::class,
                Console\PublishCommand::class,
                Console\ResourceCommand::class,
                Console\CreateAdminCommand::class,
                Console\PermissionCommand::class,
            ]);
        }


        /**
         * Register the package's publishable resources.
         *
         * @return void
         */
        protected function registerPublishing()
        {

            $this->publishes([
                __DIR__ . '/Console/stubs/ZoroasterServiceProvider.stub' => app_path('Providers/ZoroasterServiceProvider.php') ,
            ] , 'Zoroaster-provider');

            $this->publishes([
                __DIR__ . '/../config/Zoroaster.php' => config_path('Zoroaster.php') ,
            ] , 'Zoroaster-config');

            $this->publishes([
                __DIR__ . '/../publishable' => public_path('vendor/Zoroaster') ,
            ] , 'Zoroaster-assets');

//        $this->publishes([
//            __DIR__.'/../resources/lang' => resource_path('lang/vendor/Zoroaster'),
//        ], 'Zoroaster-lang');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/Zoroaster') ,
            ] , 'Zoroaster-views');

            $this->publishes([
                __DIR__ . '/../database' => database_path() ,
            ] , 'Zoroaster-migrations');
        }

        /**
         * Register the package resources such as routes, templates, etc.
         *
         * @return void
         */
        protected function registerResources()
        {
            $this->loadViewsFrom(__DIR__ . '/../resources/views' , 'Zoroaster');
//            $this->loadTranslationsFrom(__DIR__ . '/../resources/lang' , 'Zoroaster');
//            $this->loadJsonTranslationsFrom(resource_path('lang/vendor/Zoroaster'));
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
            $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');


        }


        private function Helpers()
        {
            foreach(glob(__DIR__ . '/Helpers/*.php') as $file)
            {
                require_once($file);
            }
        }

        private function Gates()
        {
            if(!config('Zoroaster.permission')) return;

            foreach(\KarimQaderi\Zoroaster\Models\Permission::all() as $permission)
            {
                Gate::define($permission->name , function($user) use ($permission)
                {
                    return $user->hasPermission($permission->name);
                });
            }


        }
    }
