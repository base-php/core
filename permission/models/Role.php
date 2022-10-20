<?php

namespace App\Models;

class Role
{
	protected $table = 'roles';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'description', 'date_create', 'date_update'];

    public function permissions()
    {
        $permissions = DB::table('permissions')
            ->select('permissions.id', 'permissions.name', 'permissions.description')
            ->leftJoin('role_has_permissions', 'permissions.id = role_has_permissions.id_role')
            ->where('role_has_permissions.id_role', $this->id)
            ->get();

        return $permissions;
    }
}
