<?php

class SugerenciasController
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
        $username = $_SESSION['user'];
        $preguntas = $this->model->obtenerPreguntasPorEstado(1);

        $this->presenter->show('sugerencias', ['username' => $username, 'preguntas' => $preguntas]);
    }

    public function activar()
    {
        $idPregunta = $_GET['id'];

        $this->model->cambiarEstadoPregunta($idPregunta,2);

        header('Location: /sugerencias');
        exit();
    }

    public function rechazar()
    {
        $idPregunta = $_GET['id'];

        $this->model->cambiarEstadoPregunta($idPregunta,4);

        header('Location: /sugerencias');
        exit();
    }
}