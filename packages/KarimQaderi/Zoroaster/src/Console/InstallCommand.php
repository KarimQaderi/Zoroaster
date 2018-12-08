<?php

namespace Laravel\Nova\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{

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
        $this->comment('Publishing Nova Assets / Resources...');
        $this->callSilent('Zoroaster:publish');

        $this->comment('Publishing Nova Service Provider...');
        $this->callSilent('vendor:publish', ['--tag' => 'Zoroaster-provider']);


        $this->comment('Generating User Resource...');
        $this->callSilent('nova:resource', ['name' => 'User']);
        copy(__DIR__.'/AppZoroaster/Other/Dashboard.stub', app_path('Zoroaster/Other/Dashboard.php'));
        copy(__DIR__.'/AppZoroaster/Other/Sidebar.stub', app_path('Zoroaster/Other/Sidebar.php'));
        copy(__DIR__.'/AppZoroaster/Resources/Post.stub', app_path('Zoroaster/Resources/Post.php'));
        copy(__DIR__.'/AppZoroaster/Resources/User.stub', app_path('Zoroaster/Resources/User.php'));


        $this->info('Nova scaffolding installed successfully.');
    }


}
