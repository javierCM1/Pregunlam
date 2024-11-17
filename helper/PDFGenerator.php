<?php

require_once 'vendor\dompdf\dompdf\src\Dompdf.php';
use Dompdf\Dompdf;

class PDFGenerator
{
    public function __construct()
    {
    }

    public function render($html)
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4');
        $dompdf->render();
        $dompdf->stream("estadisticas.pdf" , ['Attachment' => 1]);
    }
}