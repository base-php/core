<?php

trait Log
{
	public function __construct()
	{
		$id_user = auth()->id;
		$id_model = $this->id;
		$model = get_class($this);
		$action = __METHOD__;

		$item = DB::table($this->getTable())
			->where('id', $id_model)
			->first();

		$old = [];

		foreach ($this->getFillable() as $fillable) {
			$old[$fillable] = $item->$fillable;
		}

		$new = [];

		foreach ($this->getFillable() as $fillable) {
			$old[$fillable] = request($fillable);
		}

		$parameters = ['old' => $old, 'new' => $new];
		$paramters = json_encode($parameters);

		DB::table('logs')->insert([
			'id_user'		=> $id_user,
			'id_model'		=> $id_model,
			'model'			=> $model,
			'action'		=> $action,
			'parameters'	=> $parameters,
			'date_create'	=> date('Y-m-d h:i:s'),
			'date_update'	=> date('Y-m-d h:i:s'),
		]);
	}
}
