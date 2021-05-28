<?php

/**
 * Generate file Excel
 */
class Excel
{
	/**
     * View corresponding to the file.
     *
     * $view string
     */
	public $view;

	/**
     * Data corresponding to the file.
     *
     * $data array
     */
	public $data;

	/**
     * Name of the downloaded file.
     *
     * $download string
     */
	public $download;

	/**
     * Name of the stored file.
     *
     * $store string
     */
	public $store;

	/**
     * Initialize the class to use from a global function.
     *
     * @return Excel
     */
    public static function init()
    {
        $class = new static;
        return $class;
    }

	/**
	 * Set variable view.
	 *
	 * @param $view string
	 * @return Excel
	 */
	public function view($view)
	{
		$this->view = $view;
		return $this;
	}

	/**
	 * Set variable data.
	 *
	 * @param $data array|object
	 * @return Excel
	 */
	public function data($data)
	{
		$this->data = $data;
		return $this;
	}

	/**
	 * Force the download.
	 *
	 * @param $download string
	 * @return Excel
	 */
	public function download($download)
	{
		$this->download = $download;
		header('Content-Type: application/vnd.ms-excel');
	    header('Content-Disposition: attachment; filename=' . $this->download . '.xls');
	    extract($this->data);
	    include $_SERVER['DOCUMENT_ROOT'] . '/resources/views/' . $this->view . '.php';
	    return $this;
	}

	/**
	 * Store the file.
	 *
	 * @param $store string
	 * @return Excel
	 */
	public function store($store)
	{
		ob_start();
		$this->store = $store;
		extract($this->data);
		include $_SERVER['DOCUMENT_ROOT'] . '/resources/views/' . $this->view . '.php';
		file_put_contents($this->store . '.xls', ob_get_clean());
		return $this;
	}
}

/**
 * Initialize global helper.
 *
 * @return Excel
 */
function excel()
{
    return Excel::init();
}
