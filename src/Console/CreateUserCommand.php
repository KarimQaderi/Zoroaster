<?php

    namespace KarimQaderi\Zoroaster\Console;

    use Illuminate\Console\Command;
    use Illuminate\Console\DetectsApplicationNamespace;
    use Illuminate\Support\Facades\Hash;

    class CreateUserCommand extends Command
    {
        use DetectsApplicationNamespace;
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'Zoroaster:user';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Create User';

        /**
         * Execute the console command.
         *
         * @return void
         */
        public function handle()
        {

            $email = $this->ask('email');

            $model = config('auth.providers.users.model');

            $check_has_user = $model::where('email' , $email)->first();

            if(is_null($check_has_user))
            {
                $name = $this->ask('Enter the admin name');
                $password = $this->secret('Enter admin password');
                $confirmPassword = $this->secret('Confirm Password');

                // Ask for email if there wasnt set one
                if(!$email)
                {
                    $email = $this->ask('Enter the admin email');
                }

                // Passwords don't match
                if($password != $confirmPassword)
                {
                    $this->info("Passwords don't match");

                    return;
                }

                $model::create([
                    'name' => $name ,
                    'email' => $email ,
                    'password' => Hash::make($password) ,
                ]);

                $this->info('Creating admin account');

            }
            else
            {
                $this->info('his email is already out of stock');

            }


        }


    }
