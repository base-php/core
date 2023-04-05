<?php

class Chart
{
	public $dataset = [];
	public $labels;
	public $options;

	public function dataset($name, $type, $data)
	{
		$count = count($this->dataset);

		$this->dataset[$count]['name'] = $name;
		$this->dataset[$count]['type'] = $type;
		$this->dataset[$count]['data'] = $data;

		return $this;
	}

	public function labels($labels)
	{
		$this->labels = $labels;
		return $this;
	}

	public function options($options)
	{
		$this->options = $options;
		return $this;
	}
}