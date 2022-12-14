<?php

namespace App\Models;

use DB;

trait HasRole
{
	public function assignRole($name)
	{
		DB::table('user_has_role')
			->where('id_user', $this->id)
			->delete();

		$id_role = DB::table('roles')
			->where('name', $name)
			->first()
			->id;

		DB::table('user_has_role')
			->insert([
				'id_user' => $this->id,
				'id_role' => $id_role
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
		$role = DB::table('roles')
			->leftJoin('user_has_role', 'roles.id', '=', 'user_has_role.id_role')
			->where('user_has_role.id_role', $this->id)
			->first();

		return $role->name;
	}

	public function removeRole($role)
	{
		DB::table('user_has_role')
			->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('roles')
                    ->where('name', $permission);
            })
			->delete();
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
