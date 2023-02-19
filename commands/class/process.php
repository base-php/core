<?php

class Process
{
	public $output;

	public function run($cmd)
	{
		exec($cmd, $this->output);
		$this->output = implode("\n", $this->output);
		return $this;
	}

	public function output()
	{
		return $this->output;
	}
}
