<?php

namespace App\Models;

use DB;

trait HasRole
{
	public function assignRole($name)
	{
		$id_role = DB::table('roles')
			->where('name', $name)
			->first()
			->id;

		DB::table('user_has_roles')
			->insert([
				'id_user' => $this->id,
				'id_role' => $id_role
			]);
	}

	public function can($permission)
	{
		if (!isset($_SESSION['basephp-permissions'])) {
			$db = DB::select("
				SELECT
					p.*
				FROM
					permissions p
						LEFT JOIN role_has_permissions rp ON p.id = rp.id_permission
						LEFT JOIN roles r ON rp.id_role = r.id
						LEFT JOIN user_has_roles ur ON ur.id_role = r.id
						LEFT JOIN users u ON u.id = ur.id_user
				WHERE
					u.id = '{$this->id}'
			");

			$_SESSION['basephp-permissions'] = $db;
		} else {
			$db = $_SESSION['basephp-permissions'];
		}

		if (in_array($permission, array_column($db, 'name'))) {
			return true;
		}

		return false;
	}

	public function getRoles()
	{
		$roles = DB::table('roles')
			->leftJoin('user_has_roles', 'roles.id', '=', 'user_has_roles.id_role')
			->where('user_has_roles.id_role', $this->id)
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
			->leftJoin('roles', 'roles.id', '=', 'user_has_roles.id_role')
			->where('roles.name', $role)
			->get();

		if ($db->count()) {
			return true;
		}

		return false;
	}
}
