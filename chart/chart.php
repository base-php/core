<?php

class Chart
{
	public $dataset = [];
	public $labels;
	public $options;
	public $scriptAttribute = '';
	public $type;

	public function dataset($name, $data)
	{
		$count = count($this->dataset);

		$this->dataset[$count]['name'] = $name;
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

	public function script()
	{
		if ($this->type == 'chartjs') {
			echo '<script ' . $this->scriptAttribute . ' src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.min.js"></script>';
		}

		if ($this->type == 'highcharts') {
			echo '<script ' . $this->scriptAttribute . ' src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.3.3/highcharts.js"></script>';
			echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.3.3/css/highcharts.min.css">';
		}

		if ($this->type == 'fusioncharts') {
			echo '<script ' . $this->scriptAttribute . ' src="https://cdnjs.cloudflare.com/ajax/libs/fusioncharts/3.20.0/fusioncharts.js"></script>';
		}

		if ($this->type == 'echarts') {
			echo '<script ' . $this->scriptAttribute . ' src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.4.2/echarts.min.js"></script>';
		}

		if ($this->type == 'c3') {
			echo '<script ' . $this->scriptAttribute . ' src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.min.js"></script>';
			echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.css">';
		}
	}

	public function setScriptAttribute($scriptAttribute)
	{
		$keys = array_keys($scriptAttribute);
		$values = array_values($scriptAttribute);

		$scriptAttribute = $keys[0] . '="' . $values[0] . '"';

		$this->scriptAttribute = $scriptAttribute;
		return $this;
	}
}