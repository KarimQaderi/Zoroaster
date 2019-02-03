<?php

    namespace KarimQaderi\Zoroaster\Console;

    use Illuminate\Console\Command;
    use Illuminate\Console\DetectsApplicationNamespace;

    class InstallCommand extends Command
    {
        use DetectsApplicationNamespace;
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'Zoroaster:install';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'نصب زرتشت';

        /**
         * Execute the console command.
         *
         * @return void
         */
        public function handle()
        {
            $this->comment('Start install Zoroaster');

            $this->callSilent('Zoroaster:publish');

//            $this->registerZoroasterServiceProvider();

            \Zoroaster::makeDirectory(app_path('Zoroaster/Other'));
            \Zoroaster::makeDirectory(app_path('Zoroaster/Resources'));
            \Zoroaster::makeDirectory(app_path('Zoroaster/Metrics'));

            copy(__DIR__ . '/App/Zoroaster/Other/Dashboard.stub' , app_path('Zoroaster/Other/Dashboard.php'));
            copy(__DIR__ . '/App/Zoroaster/Other/Navbar.stub' , app_path('Zoroaster/Other/Navbar.php'));
            copy(__DIR__ . '/App/Zoroaster/Other/Sidebar.stub' , app_path('Zoroaster/Other/Sidebar.php'));
            copy(__DIR__ . '/App/Zoroaster/Resources/User.stub' , app_path('Zoroaster/Resources/User.php'));
            copy(__DIR__ . '/App/Zoroaster/Metrics/UserCount.stub' , app_path('Zoroaster/Metrics/UserCount.php'));
            copy(__DIR__ . '/App/Zoroaster/Metrics/UserCountOverTime.stub' , app_path('Zoroaster/Metrics/UserCountOverTime.php'));


//            $this->call('migrate');


            $this->info('Zoroaster installed successfully');
        }

        /**
         * Register the Zoroaster service provider in the application configuration file.
         *
         * @return void
         */
        protected function registerZoroasterServiceProvider()
        {
            $namespace = str_replace_last('\\' , '' , $this->getAppNamespace());

            $app = file_get_contents(config_path('app.php'));

            if(str_contains($app , "KarimQaderi\Zoroaster\ZoroasterCoreServiceProvider::class") === false)
                file_put_contents(config_path('app.php') , str_replace(
                    "{$namespace}\Providers\EventServiceProvider::class," ,
                    PHP_EOL . "        {$namespace}\Providers\EventServiceProvider::class," . PHP_EOL . "        KarimQaderi\Zoroaster\ZoroasterCoreServiceProvider::class," ,
                    $app));

        }


    }
