<?php


class PerfilController
{

    private $userModel;
    private $presenter;
    private $partidaModel;
    private $qrHandler;

    public function __construct($userModel, $partidaModel, $presenter, $qrHandler)
    {
        $this->userModel = $userModel;
        $this->presenter = $presenter;
        $this->partidaModel = $partidaModel;
        $this->qrHandler = $qrHandler;
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $data['usuario'] = $this->userModel->getUserByUsernameOrEmail($_SESSION['user'], 'a');
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $data['perfil'] = $this->userModel->getUserProfileById($id);
        $data['partidas'] = $this->partidaModel->getPartidasByUserId($data['perfil']['id_usuario']);

        if ($data['perfil'] == null) {
            header("Location: /perfil?id=" . $data['usuario']['id_usuario']);
            exit();
        }

        $data['qrUsuario'] = $this->qrHandler->generateQRCode($data['perfil']['id_usuario']);
        $data['message'] = $_SESSION['errorActualizacion'] ?? '';

        if ($data['usuario']['id_usuario'] === $data['perfil']['id_usuario']) {
            $data['perfilUsuario'] = true;
        }

        $this->presenter->show('perfil', $data);
        unset($_SESSION['errorActualizacion']);
    }
}