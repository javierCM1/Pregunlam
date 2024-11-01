<?php

class RankingController
{
    private $userModel;
    private $presenter;

    private $qrHandler;

    public function __construct($userModel, $presenter,$qrHandler)
    {
        $this->qrHandler = $qrHandler;
        $this->userModel = $userModel;
        $this->presenter = $presenter;
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $ranking = $this->userModel->getRankingUsuarios();
        $ranking = $this->userModel->getRankingPositions($ranking);

        foreach ($ranking as $usuario) {
            $data['qr'] = $this->qrHandler->generateQRCode($usuario['id_usuario']);
        }

        $data['usuario'] = $this->userModel->getUserByUsernameOrEmail($_SESSION['user'],'a');
        $data['rankingUsuarios'] = $ranking;
        $data['audio_src'] = '/public/music/WhatsApp Audio 2024-10-28 at 23.22.09.mpeg';

        // Renderizar la vista ranking con los datos
        $this->presenter->show('ranking', $data);
    }

}

