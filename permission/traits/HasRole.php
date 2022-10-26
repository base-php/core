<?php

namespace App\Models;

use DB;

trait HasRole
{
	public function assignRole($name)
	{
		$role = DB::table('roles')
			->where('name', $name)
			->first();

		DB::table('user_has_role')
			->where('id_user', $this->id)
			->delete();

		DB::table('user_has_role')->insert([
			'id_user' => $this->id,
			'id_role' => $role->id
		]);
	}

	public function can($permission)
	{
		$permission = DB::table('permissions')
			->where('name', $permission)
			->first();

		$role = DB::table('user_has_role')
			->where('id_user', $this->id)
			->first();

		$permission = DB::table('role_has_permissions')
			->where('id_role', $role->id)
			->where('id_permission', $permission->id)
			->get();

		if ($permission->count()) {
			return true;
		}

		return false;
	}

	public function getRole()
	{
		$id_user = $this->id;

		$role = DB::table('roles')
			->leftJoin('user_has_role', 'roles.id', '=', 'user_has_role.id_role')
			->where('user_has_role.id_role', $id_user)
			->get();

		return $role->name;
	}

	public function removeRole($role)
	{
		DB::statement("DELETE FROM user_has_role WHERE id IN (SELECT id FROM roles WHERE name = '$role')");
	}

	public function role($role)
	{
		$db = DB::table('user_has_role')
			->leftJoin('roles', 'roles.id', '=', 'user_has_role.id_role')
			->where('roles.name', $role)
			->get();

		if ($db->count()) {
			return true;
		}

		return false;
	}
}
