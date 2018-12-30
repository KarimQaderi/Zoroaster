<?php

    namespace KarimQaderi\Zoroaster\Traits;


    use KarimQaderi\Zoroaster\Models\Permission;

    trait HasPermissions
    {

        public function permissions()
        {
            return $this->belongsToMany(Permission::class , 'role_has_permissions');

        }


        public function hasPermission($permission_name)
        {
            $find = Permission::with(['role_has_permissions' => function($q) use ($permission_name)
            {
                $q->where('role_id' , $this->{'role_id'});

            }])->where('name' , $permission_name)->first();

            return (bool)(is_null($find)? false : $find->role_has_permissions->count());
        }
    }