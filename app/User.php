<?php

    namespace App;

    use App\models\Post;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use KarimQaderi\Zoroaster\Traits\HasPermissions;

    class User extends Authenticatable
    {
        use Notifiable , HasPermissions;

        public $displayTitleField = 'name';
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name' , 'email' , 'password' ,
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password' , 'remember_token' ,
        ];


        public function posts()
        {
            return $this->hasMany(Post::class);
        }

    }
