<?php

class Redirect
{
	public $to;

	public function __toString()
	{
		return '';
	}

	public function redirect($to)
	{
		$this->to = $to;
	}

	public function with($key, $value)
	{
		$_SESSION['flashmessages'][$key] = $value;
	}

	public function __destruct()
	{
		echo "
			<script>
				window.location.href = '$this->to';
			</script>
		";
	}
}
