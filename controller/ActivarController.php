<?php

class ActivarController
{
    public function __construct($model, $presenter)
    {
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function index()
    {
        $this->presenter->show('activar', []);
    }

    public function auth()
    {
        $usuario = $_GET['username'] ?? $this->model->getUserByUsernameOrEmail($_SESSION['pendiente'])['userName_usuario'];
        $token = $_GET['token'];

        if ($this->model->validateActivation($usuario, $token))
        {
            //$message = '¡Cuenta activada exitosamente!';
            //$this->presenter->show('lobby', ['message' => $message, 'usuario' => $usuario]);

            $_SESSION['user'] = $usuario;
            header('Location: /lobby'); //temporal, implementar modal
            exit();
        }
        else
        {
            $message = 'Código de verificación incorrecto';
            $this->presenter->show('activar', ['message' => $message, 'username' => $usuario]);
        }
    }
}