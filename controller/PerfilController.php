<?php




class PerfilController
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

        $data['usuario'] = $this->model->getUserByUsernameOrEmail($_SESSION['user'],'a');
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $data['perfil']  = $this->model->getUserById($id);
        $this->presenter->show('perfil', $data);
    }
}