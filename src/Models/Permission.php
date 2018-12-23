<?php

    namespace KarimQaderi\Zoroaster\Models;

    use Illuminate\Database\Eloquent\Model;

    class Permission extends Model
    {
        protected $guarded = [];

        public function role_has_permissions()
        {
            return $this->belongsToMany(Permission::class , 'role_has_permissions');
        }


    }
