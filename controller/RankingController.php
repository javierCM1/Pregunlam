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
        $ranking = $this->userModel->getRankingUsuarios();
        $ranking = $this->userModel->getRankingPositions($ranking);

        foreach ($ranking as $usuario) {
            $data['qr'] = $this->qrHandler->generateQRCode($usuario['id_usuario']);//mustra el último qr generado para todos los del ranking
        }

        $data['usuario'] = $this->userModel->getUserByUsernameOrEmail($_SESSION['user'],'a');
        $data['rankingUsuarios'] = $ranking;
        $data['audio_src'] = 'public/music/kevin.mp3';

        // Renderizar la vista ranking con los datos
        $this->presenter->show('ranking', $data);
    }

}

