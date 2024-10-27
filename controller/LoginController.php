<?php

class LoginController
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
        $this->presenter->show('login', []);
    }

    public function auth()
    {
        $user = $_POST['user'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($this->model->validateLogin($user, $password, 'a'))
        {
            $_SESSION['user'] = $user;
            $tipoUsuario = $this->model->getTipoUsuario($user);
            if ($tipoUsuario == 2) {
                header('Location: /editor');
                exit();
            } else {
                header('Location: /lobby');
                exit();
            }
        }
        else if($this->model->validateLogin($user, $password, 'p'))
        {
            $_SESSION['pendiente'] = $user;
            header('Location: /activar');
            exit();
        }
        else
        {
            $message = 'Correo o contraseña incorrectos.';
            $this->presenter->show('login', ['message' => $message, 'username' => $user]);
        }
    }

}