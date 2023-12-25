<?php

namespace App\Models;

trait Searchable
{
	public function searchable($text)
	{
		$class = get_class($this);
		$model = new $class;

		$fields = $this->getFillable();

		foreach ($fields as $field)
		{
			$model->orWhere($field, 'LIKE', '%' . $text . '%');
		}

		return $model->get();
	}
}
