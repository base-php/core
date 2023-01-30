<?php

namespace App\Controllers;

trait CRUD
{
	public $buttons;
	public $class;
	public $css;
	public $items;
	public $style;
	public $widgets;

	public function resolve($method, $argument = null)
	{
		$this->$method();

		$data['fields'] = (object) $this->fields;
		$data['items'] = $this->items;

		$data['class'] = isset($this->class) ? (object) $this->class : (object) [];
		$data['style'] = isset($this->style) ? (object) $this->style : (object) [];

		$data['css'] = isset($this->css) ? (object) $this->css : (object) [];
		$data['js'] = isset($this->js) ? (object) $this->js : (object) [];

		$data['buttons'] = isset($this->buttons) ? (object) $this->buttons : (object) [];

		$data['widgets'] = isset($this->widgets) ? (object) $this->widgets : (object) [];

		$data['paginationView'] = $this->paginationView ?? 'default';

		$data['widgets'] = isset($this->widgets) ? (object) $this->widgets : (object) [];

		$data['filters'] = $this->filters ?? null;

		$data['edit'] = $this->edit ?? true;
		$data['show'] = $this->show ?? true;
		$data['delete'] = $this->delete ?? true;

		return view('crud:' . $method, $data);
	}
}
