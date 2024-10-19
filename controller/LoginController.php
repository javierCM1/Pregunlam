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
        //$user = isset($_POST['user']) && !preg_match('/\W/',$_POST['user']) ? $_POST['user'] : '';
        $password = $_POST['password'] ?? '';
        //$password = isset($_POST['password']) && !preg_match('/\S/',$_POST['password']) ? $_POST['password'] : '';

        if ($this->model->validateLogin($user, $password, 'a'))
        {
            $_SESSION['user'] = $user;
            header('Location: /lobby');
            exit();
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