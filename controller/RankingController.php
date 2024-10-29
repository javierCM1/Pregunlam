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
        $this->presenter->show('ranking', $data);
    }

}

