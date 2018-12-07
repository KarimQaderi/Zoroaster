<?php

    namespace App\models;

    use Illuminate\Database\Eloquent\Model;

    class Post extends Model
    {
//        public $displayTitleField = 'title';
//        public $labels = 'پست ها'; // Resource Name
//        public $label = 'پست'; // Resource Name
//
//        // ** Routes Start ** //
//        // Routes Strind Resource
//        public $routes = 'back.post';
//
//        // OR
////        public $routes = [
////            'index' => 'back.post.index' ,
////            'create' => 'back.post.create' ,
////            'store' => 'back.post.store' ,
////            'update' => 'back.post.update' ,
////            'show' => 'back.post.show' ,
////            'destroy' => 'back.post.destroy' ,
////            'edit' => 'back.post.edit ,
////        ];
//        // ** Routes End ** //
//

        protected $guarded = [];
        protected $casts = [
            'img_multi' => 'array' ,
//            'img' => 'array' ,
        ];
    }
