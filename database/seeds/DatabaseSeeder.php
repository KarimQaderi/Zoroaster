<?php

    use App\User;
    use Illuminate\Database\Seeder;

    class DatabaseSeeder extends Seeder
    {
        /**
         * Seed the application's database.
         *
         * @return void
         */
        public function run()
        {
            User::create([
                'name' => 'admin' ,
                'email' => 'admin@admin.com' ,
                'email_verified_at' => now() ,
                'password' => Hash::make('123456') ,
                'is_admin' => true
            ]);


            factory(App\User::class, 100)->create();
            factory(App\Models\Post::class, 50)->create();
            factory(App\Models\Categorie::class, 20)->create();
            factory(App\Models\CategoriePivot::class, 80)->create();

//            $this->call(UsersTableSeeder::class);

        }
    }
