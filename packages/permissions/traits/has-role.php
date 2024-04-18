<?php

namespace App\Models;

use DB;

trait HasRole
{
    public function assignRole($name)
    {
        $role_id = DB::table('roles')
            ->where('name', $name)
            ->first()
            ->id;

        DB::table('user_has_roles')
            ->insert([
                'user_id' => $this->id,
                'role_id' => $role_id,
            ]);
    }

    public function can($permission)
    {
        if (! session('basephp-permissions')) {
            $db = DB::select("
				SELECT
					p.*
				FROM
					permissions p
						LEFT JOIN role_has_permissions rp ON p.id = rp.permission_id
						LEFT JOIN roles r ON rp.role_id = r.id
						LEFT JOIN user_has_roles ur ON ur.role_id = r.id
						LEFT JOIN users u ON u.id = ur.user_id
				WHERE
					u.id = '{$this->id}'
			");

            session('basephp-permissions', $db);
        } else {
            $db = session('basephp-permissions');
        }

        if (in_array($permission, array_column($db, 'name'))) {
            return true;
        }

        return false;
    }

    public function getRoles()
    {
        $roles = DB::table('roles')
            ->leftJoin('user_has_roles', 'roles.id', '=', 'user_has_roles.role_id')
            ->where('user_has_roles.role_id', $this->id)
            ->get();

        return $roles;
    }

    public function removeRole($role)
    {
        DB::table('user_has_roles')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('roles')
                    ->where('name', $permission);
            })
            ->delete();
    }

    public function role($role)
    {
        $db = DB::table('user_has_roles')
            ->leftJoin('roles', 'roles.id', '=', 'user_has_roles.role_id')
            ->where('roles.name', $role)
            ->get();

        if ($db->count()) {
            return true;
        }

        return false;
    }
}
