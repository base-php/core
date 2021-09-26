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
	 * @return void
	 */
	public function redirect(string $to): void
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
	public function with(string $key, string $value): void
	{
		$_SESSION['flashmessages'][$key] = $value;
	}

	/**
	 * Make redirection.
	 *
	 * @return void
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
