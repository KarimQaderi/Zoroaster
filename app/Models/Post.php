<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class Post extends Model
    {
        use SoftDeletes;

        protected $guarded = [];
        protected $casts = [
            'img_multi' => 'array' ,
            'file' => 'array' ,
//            'img' => 'array' ,
        ];
    }
