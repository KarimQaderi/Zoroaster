<?php

    namespace KarimQaderi\Zoroaster\Traits;


    use KarimQaderi\Zoroaster\Models\Permission;

    trait HasPermissions
    {
        public $permissions = null;

        public function permissions()
        {
            return $this->belongsToMany(Permission::class , 'role_has_permissions');

        }


        public function hasPermission($permission_name)
        {
            if(empty($this->permissions))
                $this->permissions = Permission::with(['role_has_permissions' => function($q) use ($permission_name)
                {
                    $q->where('role_id' , $this->{'role_id'});

                }])->select('name' , 'id')->get();

            $find = $this->permissions->where('name' , $permission_name)->first();

            return (bool)(is_null($find) ? false : $find->role_has_permissions->count());
        }
    }