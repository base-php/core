<?php

use App\Models\User;

class Feature
{
	public $user;

	public function activate($name)
	{
		$scope = $this->getScope();

		DB::table('features')
			->where('name', $name)
			->where('scope', $scope)
			->update(['value' => true]);
	}

	public function active($name)
	{
		$scope = $this->getScope();

		$feature = DB::table('features')
			->where('name', $name)
			->where('scope', $scope)
			->first();

		if ($feature->value) {
			return true;
		}

		return false;
	}

	public function deactivate($name)
	{
		$scope = $this->getScope();

		DB::table('features')
			->where('name', $name)
			->where('scope', $scope)
			->update(['value' => false]);
	}

	public function define($name, $condition)
	{
		$scope = $this->getScope();

		$value = is_object($condition) ? $condition->resolve() : $condition;

		$data = [
			'name' => $name,
			'scope' => $scope,
			'value' => $value
		];

		DB::table('features')
			->insert($data);
	}

	public function forget($name)
	{
		$scope = $this->getScope();

		DB::table('features')
			->where('name', $name)
			->where('scope', $scope)
			->delete();
	}

	public function for($user)
	{
		$this->user = $user;
		return $this;
	}

	public function getScope()
	{
		if (! $this->user) {
			$this->user = User::find(auth()->id);
		}

		$scope = get_class($this->user) . '|' . $this->user->id;

		return $scope;
	}
}
