<?php

namespace App\Permission;

trait Permission
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
}
