<?php

use Dompdf\Dompdf;
use Dompdf\Options;

class PDF
{
    public function download($object, $filename)
    {
        ob_start();

        $object->view();

        $options = new Options();
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(utf8_encode(ob_get_clean()));

        if ($object->lanscape) {
            $dompdf->set_paper('a4', 'landscape');
        }

        $dompdf->render();
        $dompdf->stream($filename . '.pdf');
    }

    public function store($object, $filename)
    {
        ob_start();

        $object->view();

        $options = new Options();
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(utf8_encode(ob_get_clean()));

        if ($object->lanscape) {
            $dompdf->set_paper('a4', 'landscape');
        }

        $dompdf->render();

        file_put_contents($filename . '.pdf', $dompdf->output());
    }
}
