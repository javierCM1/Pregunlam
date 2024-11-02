<?php

class EditorController
{
    private $model;
    private $presenter;

    public function __construct($model, $presenter)
    {
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $username = $_SESSION['user'];
        $preguntas = $this->model->obtenerPreguntasPorEstado(2);

        $this->presenter->show('editor', ['username' => $username, 'preguntas' => $preguntas]);
    }

    public function desactivar()
    {
        $idPregunta = $_GET['id'];

        $this->model->cambiarEstadoPregunta($idPregunta,5);

        header('Location: /editor');
        exit();
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