<?php

    use App\User;
    use Illuminate\Database\Seeder;
    use KarimQaderi\Zoroaster\Models\Permission;
    use KarimQaderi\Zoroaster\Models\Role;
    use KarimQaderi\Zoroaster\Models\RoleHasPermission;

    class DatabaseSeeder extends Seeder
    {
        /**
         * Seed the application's database.
         *
         * @return void
         */
        public function run()
        {

            $user = [
                'name' => 'Karim Qaderi' ,
                'email' => 'karimqaderi1@gmail.com' ,
                'email_verified_at' => now() ,
                'password' => Hash::make('123456') ,
            ];

            if(config('Zoroaster.permission'))
            {
                $user = array_prepend($user , '1' , 'role_id');

                $Role = Role::create([
                    'name' => 'ادمین' ,
                    'guard_name' => 'web' ,
                ]);

                foreach(\KarimQaderi\Zoroaster\Zoroaster::$resources as $resource)
                {
                    $resource_name = strtolower(basename($resource));
                    $resource = new $resource;
                    $Permissions = [
                        'index' => 'صفحه اصلی' , 'show' => 'صفحه نمایش' , 'create' => 'اضافه کردن' , 'update' => 'آپدیت کردن' ,
                        'delete' => 'حذف' , 'forceDelete' => 'حذف کامل' , 'restore' => 'بازیابی',
                    ];
                    foreach($Permissions as $key => $value)
                    {
                        $Permission = Permission::create(['name' => $key . '-' . $resource_name , 'display_name' => $value . ' ' . $resource->label]);
                        RoleHasPermission::create(['permission_id' => $Permission->id , 'role_id' => $Role->id]);
                    }

                }

            }

            User::create($user);


            factory(App\User::class , 100)->create();
            factory(App\Models\Post::class , 500)->create();
            factory(App\Models\Categorie::class , 20)->create();
            factory(App\Models\CategoriePivot::class , 300)->create();

//            $this->call(UsersTableSeeder::class);

        }
    }
