<?php

    namespace KarimQaderi\Zoroaster;

    use App\Zoroaster\Resources\Post;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Gate;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\ServiceProvider;
    use KarimQaderi\Zoroaster\Sidebar\FieldMenu\MenuItem;

    class ZoroasterCoreServiceProvider extends ServiceProvider
    {
        /**
         * Bootstrap any package services.
         *
         * @return void
         */
        public function boot()
        {


            if(class_exists(\App\Providers\ZoroasterServiceProvider::class))
                $this->app->register(\App\Providers\ZoroasterServiceProvider::class);

            Zoroaster::resourcesIn(config('Zoroaster.Resources'));

            if(!$this->app->configurationIsCached()){
                $this->mergeConfigFrom(__DIR__ . '/../config/Zoroaster.php' , 'Zoroaster');
            }

            Route::middlewareGroup('Zoroaster' , config('Zoroaster.middleware' , []));


            if($this->app->runningInConsole()){
                $this->registerPublishing();
            }


            if(config('Zoroaster.permission'))
                Zoroaster::SidebarMenus([
                    MenuItem::make()->resource('role')->icon('unlock') ,
                    MenuItem::make()->resource('permission')->icon('lock') ,
                ]);


            $this->registerResources();
            $this->registerCarbonMacros();
            $this->registerGates();

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
                Console\InstallCommand::class ,
                Console\PublishCommand::class ,
                Console\ResourceCommand::class ,
                Console\CreateAdminCommand::class ,
                Console\CreateUserCommand::class ,
                Console\PermissionCommand::class ,
                Console\FilterCommand::class ,
                Console\FieldCommand::class ,
            ]);
        }


        /**
         * Register the Zoroaster Carbon macros.
         *
         * @return void
         */
        protected function registerCarbonMacros()
        {
            Carbon::macro('firstDayOfQuarter' , new Macros\FirstDayOfQuarter);
            Carbon::macro('firstDayOfPreviousQuarter' , new Macros\FirstDayOfPreviousQuarter);
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
                __DIR__ . '/../publishable' => public_path('Zoroaster-assets/Zoroaster') ,
            ] , 'Zoroaster-assets');

//        $this->publishes([
//            __DIR__.'/../resources/lang' => resource_path('lang/vendor/Zoroaster'),
//        ], 'Zoroaster-lang');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/Zoroaster') ,
            ] , 'Zoroaster-views');

//            $this->publishes([
//                __DIR__ . '/../database' => database_path() ,
//            ] , 'Zoroaster-migrations');
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
//            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
            $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');


        }


        private function Helpers()
        {
            foreach(glob(__DIR__ . '/Helpers/*.php') as $file){
                require_once($file);
            }
        }

        private function registerGates()
        {

            if(!config('Zoroaster.permission')) return;

            // use $user->can('update-post'); Or $this->authorize('update-post');
            foreach(\KarimQaderi\Zoroaster\Models\Permission::all() as $permission){
                Gate::define($permission->name , function($user) use ($permission){
                    return $user->hasPermission($permission->name);
                });
            }


            // use $user->can('update', $post); Or $this->authorize('update', $post);
            $Permissions = [
                'index' => 'صفحه اصلی' , 'show' => 'صفحه نمایش' , 'create' => 'اضافه کردن' , 'update' => 'آپدیت کردن' ,
                'delete' => 'حذف' , 'forceDelete' => 'حذف کامل' , 'restore' => 'بازیابی' ,
            ];
            foreach($Permissions as $key => $value){
                Gate::define($key , function($user , $model) use ($key){
                    $basename_model = strtolower((new \ReflectionClass($model))->getShortName());

                    return $user->hasPermission($key . '-' . $basename_model);
                });
            }

        }


    }
