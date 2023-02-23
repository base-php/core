<?php

use App\Models\User;
use DB;

class Feature
{
	public $user;

	public function define($name, $condition)
	{
		$user = $this->getUser();

		$scope = get_class($this->getUser()) . '|' . $this->getUser()->id;

		$value = is_object($condition) ? $condition->resolve() : $condition;

		$data = [
			'name' => $name,
			'scope' => $scope,
			'value' => $value
		];

		DB::table('features')->insert($data);
	}

	public function getUser()
	{
		if (! $this->user) {
			$this->user = User::find(auth()->id);
		}

		return $this->user;
	}
}
