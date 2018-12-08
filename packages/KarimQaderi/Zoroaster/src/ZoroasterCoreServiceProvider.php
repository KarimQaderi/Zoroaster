<?php

    namespace KarimQaderi\Zoroaster;

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

            if(!$this->app->configurationIsCached()){
                $this->mergeConfigFrom(__DIR__ . '/../config/Zoroaster.php' , 'Zoroaster');
            }

        }

        /**
         * Register any application services.
         *
         * @return void
         */
        public function register()
        {
            if(!defined('ZOROASTER_PATH')){
                define('ZOROASTER_PATH' , realpath(__DIR__ . '/../'));
            }

            $this->Helpers();
        }

        private function Helpers()
        {
            foreach(glob(__DIR__ . '/Helpers/*.php') as $file){
                require_once($file);
            }
        }
    }
