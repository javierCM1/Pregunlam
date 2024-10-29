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

        $ranking=$this->userModel->getRankingUsuarios();
        $ranking = $this->userModel->getRankingPositions($ranking);

        $outputDir = __DIR__ . '/../public/imagesQr';

        foreach ($ranking as $usuario) {
            $codeText = "/perfil?id=" . $usuario['id_usuario'];
            $data['qr'] = $this->qrHandler->generateQRCode($codeText, $outputDir);
        }

        $data['usuario'] = $this->userModel->getUserByUsernameOrEmail($_SESSION['user'],'a');
        $data['rankingUsuarios'] = $ranking;
        $this->presenter->show('ranking', $data);
    }

}

