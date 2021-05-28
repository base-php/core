<?php

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Make a PDF file, require dompdf/dompdf package.
 */
class PDF
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
     * Set the paper type.
     *
     * $paper string
     */
    public $paper;

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
     * @return PDF
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
     * @return PDF
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
     * @return PDF
     */
    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Set variable paper.
     *
     * @param $paper string
     * @return PDF
     */
    public function paper($paper)
    {
        $this->paper = $paper;
        return $this;
    }

    /**
     * Force the download.
     *
     * @param $download string
     * @return PDF
     */
    public function download($download)
    {
        ob_start();

        $this->download = $download;
        
        extract($this->data);
        include $_SERVER['DOCUMENT_ROOT'] . '/resources/views/' . $this->view . '.php';

        $options = new Options();
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(utf8_encode(ob_get_clean()));
        if ($this->paper != '' && $this->paper) {
            $dompdf->set_paper('a4', 'landscape');
        }
        $dompdf->render();
        $dompdf->stream($this->download . '.pdf');

        return $this;
    }

    /**
     * Store the file.
     *
     * @param $store string
     * @return PDF
     */
    public function store($store)
    {
        ob_start();

        $this->store = $store;

        extract($this->data);
        include $_SERVER['DOCUMENT_ROOT'] . '/resources/views/' . $this->view . '.php';

        $options = new Options();
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(utf8_encode(ob_get_clean()));
        if ($this->paper != '' && $this->paper) {
            $dompdf->set_paper('a4', 'landscape');
        }
        $dompdf->render();

        file_put_contents($this->store . '.pdf', $dompdf->output());

        return $this;
    }
}

/**
 * Initialize global helper.
 *
 * @return PDF
 */
function pdf()
{
    return PDF::init();
}
