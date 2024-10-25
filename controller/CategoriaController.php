<?php
class CategoriaController
{
    private $model;
    private $presenter;

    public function __construct($model, $presenter){
        $this->model = $model;
        $this->presenter = $presenter;
    }
    public function index()
    {

        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }


        $data['categorias'] = $this->model->obtenerCategorias();
        $this->presenter->show('categoria', $data);
    }


}