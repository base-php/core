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
		return view('crud:index', compact('items'));
	}

	public function create()
	{
		return view('crud:create');
	}

	public function store()
	{
		$this->model->create(request());
		return redirect($route);
	}
}
