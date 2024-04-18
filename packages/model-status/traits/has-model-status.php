<?php

namespace App\Models;

trait HasModelStatus
{
	public function history()
	{
		$modelStatus = ModelStatus::where('model', $this->model()->model)
			->where('model_id', $this->model()->id)
			->get();

		return $modelStatus;
	}

	public function model()
	{
		$model = get_class($this);
		$model_id = $this->id;

		$return = [
			'model' => $model,
			'model_id' => $model_id
		];

		return (object) $return;
	}

	public function setStatus($name, $reason)
	{
		ModelStatus::create([
			'name' => $name,
			'reason' => $reason,
			'model' => $this->model()->model,
			'model_id' => $this->model()->id
		]);
	}

	public function status()
	{
		$modelStatus = ModelStatus::where('model', $this->model()->model)
			->where('model_id', $this->model()->id)
			->orderByDesc('id')
			->first();

		return $modelStatus;
	}
}
