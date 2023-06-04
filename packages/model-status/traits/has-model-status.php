<?php

namespace App\Models;

trait HasModelStatus
{
	public function model()
	{
		$model = get_class($this);
		$id_model = $this->id;

		$return = [
			'model' => $model,
			'id_model' => $id_model
		];

		return (object) $return;
	}

	public function setStatus($name, $reason)
	{
		ModelStatus::create([
			'name' => $name,
			'reason' => $reason,
			'model' => $this->model()->model,
			'id_model' => $this->model()->id
		]);
	}
}
