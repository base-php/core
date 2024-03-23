<?php

namespace App\Controllers;

trait CRUD
{
	public $layout = 'template-dashboard';
	public $model;
	public $route;
	public $scaffolding;
	public $types = [];

	public function index()
	{
		$items = $this->model->get();
		return $this->view('index', compact('items'));
	}

	public function create()
	{
		return $this->view('create');
	}

	public function store()
	{
		validation(request(), $this->validations['store']);
		$this->model->create(request());
		return redirect(plural());
	}

	public function edit($id)
	{
		$item = $this->model->find($id);
		return $this->view('edit', compact('item'));
	}

	public function update()
	{
		validation(request(), $this->validations['update']);
		$item = $this->model->find($id);
		$item->update(request());
		return redirect(plural());
	}

	public function delete($id)
	{
		$item = $this->model->find($id);
		$item->delete();
		return redirect(plural());
	}

	public function plural()
	{
		$class = get_class($this);
		$class = str_replace('App\Controllers\\', '', $class);
		$class = str_replace('Controller', '', $class);

		$plural = str()
			->to($class)
			->plural()
			->lower();

		return $plural;
	}

	public function view($view, $data)
	{
		$data['fields'] = $this->model->getFillable();
		$data['layout'] = $this->layout;
		$data['route'] = $this->route;
		$data['types'] = $this->types;

		if (file_exists($_SERVER['DOCUMENT'] . '/resources/views/' . plural() . '/' . $view . '.blade.php')) {
			return view(plural() . '.' . $view, $data);
		}

		return view('crud:' . $this->scaffolding . '/' . $view, $data);
	}
}
