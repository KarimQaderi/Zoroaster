<?php

    namespace KarimQaderi\Zoroaster\Models;

    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;

    class User extends Authenticatable
    {
        use Notifiable;

        protected $guarded = [];

    }
