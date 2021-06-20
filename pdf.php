<?php

namespace App\PDF;

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Generate PDF file, require dompdf/dompdf package.
 */
class PDF
{
    public function download($filename)
    {
        ob_start();

        $this->build();

        $options = new Options();
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(utf8_encode(ob_get_clean()));

        if ($this->lanscape) {
            $dompdf->set_paper('a4', 'landscape');
        }

        $dompdf->render();
        $dompdf->stream($filename);
    }

    public function store($filename)
    {
        ob_start();

        $this->build();

        $options = new Options();
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(utf8_encode(ob_get_clean()));

        if ($this->lanscape) {
            $dompdf->set_paper('a4', 'landscape');
        }

        $dompdf->render();

        file_put_contents($filename, $dompdf->output());
    }
}
