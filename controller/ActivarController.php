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
        if (!isset($_SESSION['pendiente'])) {
            header("Location: /login");
            exit();
        }

        $this->presenter->show('activar', []);
    }

    public function auth()
    {
        $usuario = $_GET['username'] ?? $this->model->getUserByUsernameOrEmail($_SESSION['pendiente'], 'p')['userName_usuario'];
        $token = isset($_GET['token']) && is_numeric($_GET['token']) ? $_GET['token'] : '';
        
        if ($this->model->validateActivation($usuario, $token)) {
            $_SESSION['user'] = $usuario;
            unset($_SESSION['pendiente']);
            $this->presenter->show('codigoActivado', ['usuario' => $usuario]);
            
        } else {
            $message = 'Código de verificación incorrecto';
            $this->presenter->show('activar', ['message' => $message, 'username' => $usuario]);
        }
    }
    
    public function activada()
    {
        header('Location: /lobby'); // Redirige a la vista de lobby
        exit();
    }
}