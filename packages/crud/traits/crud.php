<?php

namespace App\Controllers;

trait CRUD
{
	public $views;
	public $model;

	public function index()
	{
		$items = $this->model->get();
		return view('crud:index', compact('items'));
	}

	public function create()
	{
		return view('crud:create');
	}
}
