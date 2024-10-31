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

    public function guardarPreguntaCreada()
    {

        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        if (!isset(
            $_POST['respuestaCorrecta'],
            $_POST['respuestaincorrecta1'],
            $_POST['respuestaincorrecta2'],
            $_POST['respuestaincorrecta3'],
            $_POST['pregunta'],
            $_POST['id_categoria']
        )) {
            throw new Exception('Faltan campos obligatorios');
        }

        $pregunta = $_POST['pregunta'];
        $respuestaCorrecta = $_POST['respuestaCorrecta'];
        $respuestaIncorrecta1 = $_POST['respuestaincorrecta1'];
        $respuestaIncorrecta2 = $_POST['respuestaincorrecta2'];
        $respuestaIncorrecta3 = $_POST['respuestaincorrecta3'];
        $categoria = $_POST['id_categoria'];
        $fechaCreacion = date('Y-m-d H:i:s');

        $usuarioCreador = $this->userModel->getUserByUsernameOrEmail($_SESSION['user'], 'a')['id_usuario'];

        $this->preguntaModel->guardarPregunta($pregunta, $respuestaCorrecta, $respuestaIncorrecta1, $respuestaIncorrecta2, $respuestaIncorrecta3, $categoria, $fechaCreacion, $usuarioCreador);

        header("Location: /editor");
        exit();
    }


}