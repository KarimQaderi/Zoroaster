<?php

    namespace KarimQaderi\Zoroaster;

    use Illuminate\Support\Facades\Gate;
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

            // Configure the Zoroaster authorization services.
            Gate::define('Zoroaster' , function($user)
            {

                if(config('Zoroaster.permission'))
                    return auth()->user()->hasPermission('Zoroaster');

                return true;

            });

        }


        /**
         * Register any application services.
         *
         * @return void
         */
        public function register()
        {

        }
    }
