<?php

class RankingController
{
    private $userModel;
    private $presenter;

    public function __construct($userModel, $presenter)
    {
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

        $data['usuario'] = $this->userModel->getUserByUsernameOrEmail($_SESSION['user'],'a');
        $data['rankingUsuarios'] = $ranking;
        $this->presenter->show('ranking', $data);
    }

}

