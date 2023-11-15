<?php

namespace App\Controllers;

use App\Models\Monitor;

class MonitorController extends Controller
{
	public function __construct()
	{
		return $this->middleware('monitor');
	}

	public function index($type)
	{
		$items = Monitor::where('type', $type)->get();
		return view("monitor:$type.index", compact('items'));
	}

	public function show($type, $id)
	{
		$item = Monitor::find($id);
		return view("monitor:$type.index", compact('item'));
	}
}
