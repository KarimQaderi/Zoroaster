<?php

    namespace KarimQaderi\Zoroaster\Console;

    use Illuminate\Console\Command;
    use Illuminate\Console\DetectsApplicationNamespace;
    use Illuminate\Support\Facades\Hash;
    use KarimQaderi\Zoroaster\Models\Permission;
    use KarimQaderi\Zoroaster\Models\Role;
    use KarimQaderi\Zoroaster\Models\RoleHasPermission;

    class CreateAdminCommand extends Command
    {
        use DetectsApplicationNamespace;
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'Zoroaster:admin';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Create Admin';

        /**
         * Execute the console command.
         *
         * @return void
         */
        public function handle()
        {

            $email = $this->ask('email');

            $model = config('auth.providers.users.model');

            $create = $model::where('email' , $email)->first();

            if(is_null($create))
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


                $Role = Role::create([
                    'name' => 'ادمین' ,
                    'guard_name' => 'web' ,
                ]);

                foreach(\KarimQaderi\Zoroaster\Zoroaster::findAllResource() as $resource)
                {
                    $resource_name = strtolower(basename($resource));
                    $resource = new $resource;
                    $Permissions = [
                        'index' => 'صفحه اصلی' , 'show' => 'صفحه نمایش' , 'create' => 'اضافه کردن' , 'update' => 'آپدیت کردن' ,
                        'delete' => 'حذف' , 'forceDelete' => 'حذف کامل' , 'restore' => 'بازیابی' ,
                    ];

                    $Permission = Permission::firstOrCreate(['display_name' => 'دسترسی کلی به قسمت ادمین'],['name' => 'viewZoroaster']);
                    RoleHasPermission::firstOrCreate(['permission_id' => $Permission->id , 'role_id' => $Role->id]);

                    foreach($Permissions as $key => $value)
                    {
                        $Permission = Permission::firstOrCreate(['display_name' => $value . ' ' . $resource->label],['name' => $key . '-' . $resource_name]);
                        RoleHasPermission::firstOrCreate(['permission_id' => $Permission->id , 'role_id' => $Role->id]);
                    }

                }

                $model::create([
                    'name' => $name ,
                    'email' => $email ,
                    'role_id' => $Role->id ,
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
