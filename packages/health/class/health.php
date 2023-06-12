<?php

class Health
{
	public function view()
	{
		return view('health:index', compact('items'));
	}
}
