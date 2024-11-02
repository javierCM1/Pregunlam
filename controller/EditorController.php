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
        $estado = $_POST['estado'] ?? 2;

        $activar = null;
        if($estado != 2) {
            $activar = true;
        }

        $preguntas = $this->model->obtenerPreguntasPorEstado($estado);

        $this->presenter->show('editor', ['username' => $username, 'preguntas' => $preguntas, 'activar' => $activar]);
    }

    public function activar()
    {
        $idPregunta = $_GET['id'];

        $this->model->cambiarEstadoPregunta($idPregunta,2);

        header('Location: /editor');
        exit();
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