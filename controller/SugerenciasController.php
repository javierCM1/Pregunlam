<?php

class SugerenciasController
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
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $username = $_SESSION['user'];

        $this->presenter->show('sugerencias', ['username' => $username]);
    }
}