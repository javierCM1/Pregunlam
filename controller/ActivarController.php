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

        $data['usuario'] = $_GET['username'] ?? $this->model->getUserByUsernameOrEmail($_SESSION['pendiente'], 'p');
        $this->presenter->show('activar', $data);
    }

    public function auth()
    {
        $data['usuario'] = $_GET['username'] ?? $this->model->getUserByUsernameOrEmail($_SESSION['pendiente'], 'p');
        $token = isset($_GET['token']) && is_numeric($_GET['token']) ? $_GET['token'] : '';
        
        if ($this->model->validateActivation($data['usuario']['userName_usuario'], $token)) {
            $_SESSION['user'] = $data['usuario']['userName_usuario'];
            unset($_SESSION['pendiente']);
            $this->presenter->show('codigoActivado', $data);
            
        } else {
            $message = 'Código de verificación incorrecto';
            $this->presenter->show('activar', ['message' => $message, 'username' => $data['usuario']['userName_usuario']]);
        }
    }
    
    public function activada()
    {
        header('Location: /lobby'); // Redirige a la vista de lobby
        exit();
    }
}