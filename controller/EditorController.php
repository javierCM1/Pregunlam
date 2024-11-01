<?php

class EditorController
{

    private $model;
    private $preguntaModel;
    private $userModel;
    private $presenter;

    public function __construct($model, $preguntaModel, $userModel, $presenter)
    {
        $this->model = $model;
        $this->preguntaModel = $preguntaModel;
        $this->presenter = $presenter;
        $this->userModel = $userModel;
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $reportes = $this->model->obtenerReportes();
        $username = $_SESSION['user'];

        $this->presenter->show('editor', ['reportes' => $reportes, 'username' => $username]);
    }



    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        header("Location: /login");
        exit();
    }

}