<?php

namespace App\Models;

use DB;

class Role extends Model
{
    protected $table = 'roles';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description'
    ];

    public function givePermissionTo($permissions)
    {
        $permissions = is_array($permissions) ? $permissions : (array) $permissions;
        $role_id = $this->id;

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')
                ->insertUsing(
                    ['role_id', 'permission_id'],

                    DB::table('permissions')
                        ->selectRaw("$role_id, id")
                        ->where('name', $permission)
                );
        }
    }

    public function permissions()
    {
        $permissions = DB::table('permissions')
            ->select('permissions.id', 'permissions.name', 'permissions.description')
            ->leftJoin('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.role_id')
            ->where('role_has_permissions.role_id', $this->id)
            ->get();

        return $permissions;
    }

    public function revokePermissionTo($permissions)
    {
        $permissions = is_array($permissions) ? $permissions : (array) $permissions;

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')
                ->whereExists(function ($query) use ($permission) {
                    $query->select(DB::raw(1))
                        ->from('permissions')
                        ->where('name', $permission);
                })
                ->delete();
        }
    }

    public function syncPermissions($permissions)
    {
        $role_id = $this->id;

        DB::table('role_has_permissions')->where('role_id', $role_id)->delete();

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')
                ->insertUsing(
                    ['role_id', 'permission_id'],

                    DB::table('permissions')
                        ->selectRaw("$role_id, id")
                        ->where('name', $permission)
                );
        }
    }
}
