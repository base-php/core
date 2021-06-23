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
	 * Set redirect location.
	 *
	 * @param string $to
	 * 
	 * @return void
	 */
	public function redirect($to)
	{
		$this->to = $to;
	}

	/**
	 * Store flash messages.
	 *
	 * @param string $key
	 * @param string $value
	 * 
	 * @return void
	 */
	public function with($key, $value)
	{
		$_SESSION['flashmessages'][$key] = $value;
	}

	/**
	 * Necessary method for Symfony class.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return '';
	}

	/**
	 * Make redirection.
	 *
	 * @return string
	 */
	public function __destruct()
	{
		echo "
			<script>
				window.location.href = '$this->to';
			</script>
		";
	}
}
