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
        $usuario = $this->model->getUserByUsernameOrEmail($_SESSION['user']);
        $email = $usuario['email_usuario'];
        $token = $_POST['token'];

        if ($this->model->validateActivation($email, $token))
        {
            $message = '¡Cuenta activada exitosamente!';
            //$this->presenter->show('lobby', ['message' => $message, 'usuario' => $usuario]);
            header('Location: /lobby'); //temporal, implementar modal
            exit();
        }
        else
        {
            $message = 'Código de verificación incorrecto';
            $this->presenter->show('activar', ['message' => $message, 'username' => $email]);
        }
    }
}