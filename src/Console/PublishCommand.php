<?php

namespace KarimQaderi\Zoroaster\Console;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Zoroaster:publish {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all of the Zoroaster resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'Zoroaster-config',
            '--force' => $this->option('force'),
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'Zoroaster-assets',
            '--force' => true,
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'Zoroaster-migration-user',
            '--force' => true,
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'Zoroaster-provider',
            '--force' => true,
        ]);



//        $this->call('vendor:publish', [
//            '--tag' => 'Zoroaster-lang',
//            '--force' => $this->option('force'),
//        ]);

//        $this->call('vendor:publish', [
//            '--tag' => 'Zoroaster-views',
//            '--force' => $this->option('force'),
//        ]);

        $this->call('view:clear');
    }
}
