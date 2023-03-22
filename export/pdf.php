<?php

namespace App\PDF;

use Dompdf\Dompdf;
use Dompdf\Options;

class PDF
{
    public $instance;

    public function __construct()
    {
        if (! class_exists('Dompdf\Dompdf')) {
            throw new Exception("Please execute 'composer require dompdf/dompdf' in console.")
        }
    }

    public function generate()
    {
        ob_start();

        $this->build();

        $options = new Options();
        $options->setIsRemoteEnabled(true);

        $this->instance = new Dompdf($options);
        $this->instance->loadHtml(utf8_encode(ob_get_clean()));

        if ($this->lanscape) {
            $this->instance->set_paper('a4', 'landscape');
        }

        $this->instance->render();
    }

    public function download($filename)
    {
        $this->generate();
        $this->instance->stream($filename);
    }

    public function save($filename)
    {
        $this->generate();
        file_put_contents($filename, $this->instance->output());
    }
}
