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
            $this->comment('Publishing Zoroaster Assets / Resources...');
            $this->callSilent('Zoroaster:publish');

            $this->comment('Publishing Zoroaster Service Provider...');
            $this->callSilent('vendor:publish' , ['--tag' => 'Zoroaster-provider']);

            $this->registerZoroasterServiceProvider();

            \Zoroaster::makeDirectory(app_path('Zoroaster/Other'));
            \Zoroaster::makeDirectory(app_path('Zoroaster/Resources'));

            $this->comment('Generating User Resource...');
            copy(__DIR__ . '/AppZoroaster/Other/Dashboard.stub' , app_path('Zoroaster/Other/Dashboard.php'));
            copy(__DIR__ . '/AppZoroaster/Other/Sidebar.stub' , app_path('Zoroaster/Other/Sidebar.php'));
            copy(__DIR__ . '/AppZoroaster/Resources/Post.stub' , app_path('Zoroaster/Resources/Post.php'));
            copy(__DIR__ . '/AppZoroaster/Resources/User.stub' , app_path('Zoroaster/Resources/User.php'));


            $this->info('Zoroaster scaffolding installed successfully.');
        }

        /**
         * Register the Zoroaster service provider in the application configuration file.
         *
         * @return void
         */
        protected function registerZoroasterServiceProvider()
        {
            $namespace = str_replace_last('\\' , '' , $this->getAppNamespace());

            file_put_contents(config_path('app.php') , str_replace(
                "{$namespace}\\Providers\EventServiceProvider::class," . PHP_EOL ,
                "{$namespace}\\Providers\EventServiceProvider::class," . PHP_EOL . "        {$namespace}\Providers\ZoroasterServiceProvider::class," . PHP_EOL ,
                file_get_contents(config_path('app.php'))
            ));
        }


    }
