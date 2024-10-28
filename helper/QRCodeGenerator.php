<?php

class QRCodeGenerator
{
    public function generateQRCode($codeText, $outputDir)
    {
        if (!file_exists($outputDir))
            mkdir($outputDir, 0777, true);

        $outputFile = $outputDir . '/mi_qr.png';

        QRcode::png($codeText, $outputFile);

        return (file_exists($outputFile)) ? '/public/imagesQr/mi_qr.png' : 'Error al guardar el QR.';
    }
}