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

    for($i = 1; $i <= 1; $i++){
        $factory->define(App\Models\Post::class , function(Faker $faker){
            $w = str_limit($faker->realText() , random_int(17 , 30) , '');
            return [
                'user_id' => function(){
                    return factory(App\User::class)->create()->id;
                } ,
                'slug' => Zoroaster::url_slug($w) ,
                'title' => $w ,
                'is_published' => $faker->boolean ,
                'featured' => $faker->boolean ,
                'body' => $faker->realText(1000) ,
                'created_at' => now() ,
                'updated_at' => now() ,
            ];
        });

    }