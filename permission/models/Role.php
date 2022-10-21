<?php

namespace App\Models;

class Role extends Model
{
	protected $table = 'roles';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'description', 'date_create', 'date_update'];

    public function givePermissionTo($permissions)
    {
        $permissions = is_array($permissions) ? $permissions : (array) $permissions;
        $role = $this->id;

        foreach ($permissions as $permission) {
            DB::statement("INSERT INTO (id_role, id_permission) SELECT '$role', id FROM permission WHERE name = '$permission'");
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
}
