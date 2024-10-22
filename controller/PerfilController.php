<?php


class PerfilController
{

    private $model;
    private $presenter;

    public function __construct($model, $presenter)
    {
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $data['usuario'] = $this->model->getUserByUsernameOrEmail($_SESSION['user'], 'a');
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $data['perfil'] = $this->model->getUserProfileById($id);

        if ($data['perfil'] == null) {
            header("Location: /perfil?id=" . $data['usuario']['id_usuario']);
            exit();
        }

        $param = $data['usuario']['id_usuario'];
        $codeText = "/perfil?id=" . $param;

        $outputDir = __DIR__ . '/../public/imagesQr';
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0777, true);
        }

        $outputFile = $outputDir . '/mi_qr.png';

        QRcode::png($codeText, $outputFile);

        if (file_exists($outputFile)) {
            $data['qrUsuario'] = '/public/imagesQr/mi_qr.png';
        } else {
            echo 'Error al guardar el QR.';
        }

        $data['message'] = $_SESSION['errorActualizacion'] ?? '';

        if ($data['usuario']['id_usuario'] === $data['perfil']['id_usuario']) {
            $data['perfilUsuario'] = true;
        }

        $this->presenter->show('perfil', $data);
        unset($_SESSION['errorActualizacion']);
    }
}