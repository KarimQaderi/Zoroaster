<?php

    use Faker\Generator as Faker;

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

        $factory->define(App\Models\CategoriePivot::class , function(Faker $faker){
            return [
                'post_id' => random_int(1,50) ,
                'categorie_id' => random_int(1,20) ,
                'type' => 'post' ,
                'created_at' => now() ,
                'updated_at' => now() ,
            ];
        });

