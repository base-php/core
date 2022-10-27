<?php

namespace App\Models;

use DB;

class Role extends Model
{
	protected $table = 'roles';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'description', 'date_create', 'date_update'];

    public function givePermissionTo($permissions)
    {
        $permissions = is_array($permissions) ? $permissions : (array) $permissions;
        $id_role = $this->id;

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')
                ->insertUsing(
                    ['id_role', 'id_permission'],
                    
                    DB::table('permission')
                        ->select($id_role, 'id')
                        ->where('name', $permission)
                )
        }
    }

    public function permissions()
    {
        $permissions = DB::table('permissions')
            ->select('permissions.id', 'permissions.name', 'permissions.description')
            ->leftJoin('role_has_permissions', 'permissions.id = role_has_permissions.id_role')
            ->where('role_has_permissions.id_role', $this->id)
            ->get();

        return $permissions;
    }

    public function revokePermissionTo($permissions)
    {
        $permissions = is_array($permissions) ? $permissions : (array) $permissions;

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('permissions')
                        ->where('name', $permission)
                })
                ->delete();
        }
    }

    public function syncPermissions($permissions)
    {
        $id_role = $this->id_role;

        DB::table('role_has_permissions')->where('id_role', $id_role)->delete();

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')
                ->insertUsing(
                    ['id_role', 'id_permission'],

                    DB::table('permission')
                        ->select($id_role, 'id')
                        ->where('name', $permission)
                );
        }
    }
}
