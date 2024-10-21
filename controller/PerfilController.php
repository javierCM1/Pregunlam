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
        $data['perfil']  = $this->model->getUserProfileById($id);

        if($data['perfil'] == null) {
            header("Location: /perfil?id=".$data['usuario']['id_usuario']);
            exit();
        }

        $data['message'] = $_SESSION['errorActualizacion'] ?? '';

        if($data['usuario']['id_usuario'] === $data['perfil']['id_usuario'])
            $data['perfilUsuario'] = true;

        $this->presenter->show('perfil', $data);
        unset($_SESSION['errorActualizacion']);
    }
}