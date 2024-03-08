<?php

namespace App\Controllers;

trait CRUD
{
	public $model;
	public $route;
	public $views;

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
		$this->model->create(request());
		return redirect(plural());
	}

	public function edit($id)
	{
		$item = $this->model->find($id);
		return $this->view('edit', compact('item'));
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
		if (file_exists($_SERVER['DOCUMENT'] . '/resources/views/' . plural() . '/' . $view . '.blade.php')) {
			return view(plural() . '.' . $view, $data);
		}

		return ('crud:' . $view, $data);
	}
}
