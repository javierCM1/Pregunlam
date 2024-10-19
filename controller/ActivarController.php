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
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $data['usuario'] = $this->model->getUserByUsernameOrEmail($_SESSION['user']);
        $this->presenter->show('activar', $data);
    }

    public function auth()
    {
        $usuario = $_GET['username'] ?? $this->model->getUserByUsernameOrEmail($_SESSION['pendiente'])['userName_usuario'];
        $token = isset($_GET['token']) && is_numeric($_GET['token']) ? $_GET['token'] : '';

        if ($this->model->validateActivation($usuario, $token))
        {
            //$message = '¡Cuenta activada exitosamente!';
            //$this->presenter->show('lobby', ['message' => $message, 'usuario' => $usuario]);

            $_SESSION['user'] = $usuario;
            unset($_SESSION['pendiente']);
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