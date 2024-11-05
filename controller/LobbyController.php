<?php
class LobbyController
{

    private $userModel;
    private $presenter;
    private $partidaModel;

    public function __construct($userModel, $partidaModel, $presenter)
    {
        $this->userModel = $userModel;
        $this->presenter = $presenter;
        $this->partidaModel = $partidaModel;
    }

    public function index()
    {
        $data['usuario'] = $this->userModel->getUserByUsernameOrEmail($_SESSION['user'],'a');
        $data['partidas'] = $this->partidaModel->getPartidasByUserId($data['usuario']['id_usuario']);
        $data['audio_src'] = '/public/music/kevin.mp3';

        $this->presenter->show('lobby', $data);
    }
    public function logout()
    {
        try {
            $idUsuario = $this->userModel->getUserByUsernameOrEmail($_SESSION['user'],'a')['id_usuario'];
            $idPartida = $this->partidaModel->getPartidaActivaByUserId($idUsuario)['id_partida'];
            $this->partidaModel->terminarPartida($idPartida,$idUsuario);

            session_unset();
            session_destroy();

            header("Location: /login");
            exit();
        }
        catch (PartidaActivaNoExisteException) {
            session_start();
            session_unset();
            session_destroy();

            header("Location: /login");
            exit();
        }
    }



}