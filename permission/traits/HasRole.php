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

		$role = DB::select("SELECT r.name FROM role r LEFT JOIN user_has_role u ON r.id = u.id_role WHERE u.id_user = '$id_user'");

		return $role->name;
	}
}
