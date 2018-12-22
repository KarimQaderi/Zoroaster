<?php

    use Faker\Generator as Faker;
    use Illuminate\Support\Facades\Hash;

    /*
    |--------------------------------------------------------------------------
    | Model Factories
    |--------------------------------------------------------------------------
    |
    | This directory should contain each of the model factory definitions for
    | your application. Factories provide a convenient way to generate new
    | model instances for testing / seeding your application's database.
    |
    */

        $factory->define(App\User::class , function(Faker $faker){
            return [
                'name' => $faker->name ,
                'email' => $faker->unique()->safeEmail ,
                'email_verified_at' => now() ,
                'password' => Hash::make('123456')  , // secret
                'remember_token' => null ,
            ];
        });

