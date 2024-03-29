<?php

namespace App\Controllers;

use App\Models\Monitor;

class MonitorController extends Controller
{
	public function __construct()
	{
		return $this->middleware('monitor');

		include 'vendor/base-php/core/database/database.php';

		$schema = $capsule->getConnection('default')->getSchemaBuilder();

		if (! $schema->hasTable('monitor')) {
			throw new Exception('Please execute `php base monitor:table && php base migrate`');
		}
	}

	public function index($type = 'request')
	{
		$items = Monitor::where('type', $type)
			->orderByDesc('id')
			->get();

		return view("monitor:$type.index", compact('items'));
	}

	public function show($type, $id)
	{
		$item = Monitor::find($id);

		if (! $item) {
			return abort(404);
		}

		return view("monitor:$type.show", compact('item'));
	}

	public function delete($type)
	{
		Monitor::where('type', $type)->delete();
		return redirect("/$type");
	}
}
