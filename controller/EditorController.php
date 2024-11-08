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
        $username = $_SESSION['user'];
        $estado = $_POST['estado'] ?? 2;

        $estadoMensaje = 'activas';
        $activar = null;
        $desactivar = true;

        switch ($estado)
        {
            case 4:
                $estadoMensaje = 'rechazadas';
                $activar = true;
                $desactivar = null;
                break;
            case 5:
                $estadoMensaje = 'inactivas';
                $activar = true;
                $desactivar = null;
                break;
        }

        $preguntas = $this->model->obtenerPreguntasPorEstado($estado);
        $message = $_SESSION['message'] ?? '';

        $this->presenter->show('editor', ['username' => $username,
                                        'preguntas' => $preguntas,
                                        'activar' => $activar,
                                        'estadoMensaje' => $estadoMensaje,
                                        'desactivar' => $desactivar,
                                        'estadoPreg' => $estado,
                                        'message' => $message,
                                        'tipoUsuario' => 'editor',]);
        unset($_SESSION['message']);
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