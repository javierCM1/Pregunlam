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
        $message = '';

        $isValid = $this->model->validateLogin($email, $password);

        if ($isValid) {
            $_SESSION['user'] = $email;

            header('Location: /lobby');
            exit();
        } else {
            $message = 'Correo o contraseña incorrectos.';
            $this->presenter->show('login', ['message' => $message, 'username' => $email]);
        }
    }













}