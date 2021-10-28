<?php

/**
 * Handle all of redirections of the framework.
 */
class Redirect
{
	/**
     * Redirect location.
     *
     * $var string
     */
	public $to;

	/**
	 * Construct method for class.
	 *
	 * @return string
	 */
	public function __construct()
	{
		
	}

	/**
	 * Necessary method for Symfony class.
	 *
	 * @return void
	 */
	public function __toString()
	{
		return '';
	}

	/**
	 * Set redirect location.
	 *
	 * @param string $to
	 * 
	 * @return Redirect
	 */
	public function redirect($to)
	{
		$this->to = $to;
		return $this;
	}

	/**
	 * Store flash messages.
	 *
	 * @param string $key
	 * @param string $value
	 * 
	 * @return Redirect
	 */
	public function with($key, $value)
	{
		$_SESSION['flashmessages'][$key] = $value;
		return $this;
	}

	/**
	 * Make redirection.
	 *
	 * @return Redirect
	 */
	public function __destruct()
	{
		echo "
			<script>
				window.location.href = '$this->to';
			</script>
		";

		return $this;
	}
}
