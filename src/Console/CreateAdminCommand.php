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

            $model =new  \KarimQaderi\Zoroaster\Models\User();

            $check_has_user = $model::where('email' , $email)->first();

            if(is_null($check_has_user)){
                $name = $this->ask('Enter the admin name');
                $password = $this->secret('Enter admin password');
                $confirmPassword = $this->secret('Confirm Password');

                // Ask for email if there wasnt set one
                if(!$email){
                    $email = $this->ask('Enter the admin email');
                }

                // Passwords don't match
                if($password != $confirmPassword){
                    $this->info("Passwords don't match");

                    return;
                }
            }

            $Role = Role::firstOrCreate(['name' => 'ادمین'] , ['guard_name' => 'web']);

            foreach(\KarimQaderi\Zoroaster\Zoroaster::$resources as $resource){
                $resource = new $resource;
                $resource_name = strtolower((new \ReflectionClass($resource))->getShortName());

                $Permissions = [
                    'index' => 'صفحه اصلی' , 'show' => 'صفحه نمایش' , 'create' => 'اضافه کردن' , 'update' => 'آپدیت کردن' ,
                    'delete' => 'حذف' , 'forceDelete' => 'حذف کامل' , 'restore' => 'بازیابی' ,
                ];

                $Permission = Permission::firstOrCreate(['name' => 'Zoroaster'] , ['display_name' => 'دسترسی کلی به قسمت ادمین']);
                RoleHasPermission::firstOrCreate(['permission_id' => $Permission->id , 'role_id' => $Role->id]);

                foreach($Permissions as $key => $value){
                    $Permission = Permission::firstOrCreate(['name' => $key . '-' . $resource_name] , ['display_name' => $value . ' ' . $resource->label]);
                    RoleHasPermission::firstOrCreate(['permission_id' => $Permission->id , 'role_id' => $Role->id]);
                }

            }

            if(is_null($check_has_user)){
                $model::create([
                    'name' => $name ,
                    'email' => $email ,
                    'role_id' => $Role->id ,
                    'password' => Hash::make($password) ,
                ]);

                $this->info('Creating admin account');

            } else{
                $model::where('email' , $email)->update(['role_id' => $Role->id]);

                $this->info('update admin account');

            }


        }


    }
