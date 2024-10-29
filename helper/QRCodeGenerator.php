<?php

class QRCodeGenerator
{
    public function generateQRCode($idPerfil, $outputDir = __DIR__ . '/../public/imagesQr')
    {
        if (!file_exists($outputDir))
            mkdir($outputDir, 0777, true);

        $codeText = "http://192.168.0.21/perfil?id=" . $idPerfil; //cambiar id local si no funciona
        $outputFile = $outputDir . '/mi_qr.png';

        QRcode::png($codeText, $outputFile);

        return (file_exists($outputFile)) ? '/public/imagesQr/mi_qr.png' : 'Error al guardar el QR.';
    }
}