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
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($this->model->validateLogin($email, $password, 'a'))
        {
            session_start();
            $_SESSION['user'] = $email;
            header('Location: /lobby');
            exit();
        }
        else if($this->model->validateLogin($email, $password, 'p'))
        {
            session_start();
            $_SESSION['user'] = $email;
            header('Location: /activar');
            exit();
        }
        else
        {
            $message = 'Correo o contraseña incorrectos.';
            $this->presenter->show('login', ['message' => $message, 'username' => $email]);
        }
    }













}