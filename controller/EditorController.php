<?php

class EditorController
{

    private $model;

    private $userModel;
    private $presenter;

    public function __construct($model,$userModel, $presenter)
    {
        $this->model = $model;
        $this->presenter = $presenter;
        $this->userModel = $userModel;
    }

    public function index(){

        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $user = $_SESSION['user'];

        $tipoUsuario = $this->userModel->getTipoUsuario($user);

        if ($tipoUsuario != 2) {
            header("Location: /login");
            exit();
        }

        $reportes = $this->model->obtenerReportes();
        $username = $_SESSION['user'];

        $this->presenter->show('editor', ['reportes' => $reportes, 'username' => $username]);
    }



}