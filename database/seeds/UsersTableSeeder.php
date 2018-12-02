<?php

    use App\User;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\Hash;

    class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 100)->create();
    }
}
