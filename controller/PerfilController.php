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

        $usuario = $this->userModel->getUserByUsernameOrEmail($_SESSION['user'], 'a');
        $id = isset($_GET['id']) ? (int)$_GET['id'] : $usuario['id_usuario'];
        $perfil = $this->userModel->getUserProfileById($id);
        $partidas = $this->partidaModel->getPartidasByUserId($perfil['id_usuario']);

        if ($perfil == null) {
            header("Location: /perfil?id=" . $usuario['id_usuario']);
            exit();
        }

        if ($usuario['id_usuario'] === $perfil['id_usuario']) {
            $data['perfilUsuario'] = true;
        }

        $coordenada = $perfil['pais_usuario'];
        $coordenada = explode(",", $coordenada);
        $data['lat'] = floatval($coordenada[0]);
        $data['lng'] = floatval($coordenada[1]);

        $data['qrUsuario'] = $this->qrHandler->generateQRCode($perfil['id_usuario']);
        $data['message'] = $_SESSION['errorActualizacion'] ?? '';
        $data['usuario'] = $usuario;
        $data['perfil'] = $perfil;
        $data['partidas'] = $partidas;
        $data['audio_src'] = '/public/music/WhatsApp Audio 2024-10-28 at 23.22.09.mpeg';

        $this->presenter->show('ranking', $data);
        unset($_SESSION['errorActualizacion']);
    }
}