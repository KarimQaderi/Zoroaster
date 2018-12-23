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

        $factory->define(App\Models\Post::class , function(Faker $faker){
            $w = str_limit($faker->realText() , random_int(17 , 30) , '');
            $day = random_int(1 , now()->day);
            $month = random_int(1 , now()->month);
            $year =  now()->year;
            return [
                'user_id' => random_int(1 , 5) ,
                'slug' => Zoroaster::url_slug($w) ,
                'title' => $w ,
                'is_published' => $faker->boolean ,
                'featured' => $faker->boolean ,
                'body' => $faker->realText(1000) ,
                'created_at' => "{$year}-{$month}-{$day} 08:00:46" ,
                'updated_at' =>  "{$year}-{$month}-{$day} 08:00:46",
            ];
        });

