<?php

    namespace KarimQaderi\Zoroaster\Models;

    use Illuminate\Database\Eloquent\Model;

    class Role extends Model
    {
        protected $guarded = [];

        public function permissions()
        {
            return $this->belongsToMany(Permission::class , 'role_has_permissions');
        }
    }
