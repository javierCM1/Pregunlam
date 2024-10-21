<?php

class ModificarPerfilController
{
    private $model;
    private $presenter;
    private $profilePicHandler;

    public function __construct($model, $presenter, $profilePicHandler)
    {
        $this->model = $model;
        $this->presenter = $presenter;
        $this->profilePicHandler = $profilePicHandler;
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $data['usuario'] = $this->model->getUserByUsernameOrEmail($_SESSION['user'],'a');
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if($data['usuario']['id_usuario'] === $id) {

            switch ($data['usuario']['id_sexo']) {
                case 1:
                    $data['selectedM'] = 'selected';
                    break;
                case 2:
                    $data['selectedF'] = 'selected';
                    break;
                case 3:
                    $data['selectedX'] = 'selected';
                    break;
            }

            $this->presenter->show('modificarPerfil', $data);
        }
        else {
            header("Location: /perfil");
            exit();
        }
    }

    public function update()
    {
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $fullname = $_POST['fullname'] ?? '';
            $gender = $_POST['gender'] ?? '';
            $country = $_POST['country'] ?? '';

            if ($fullname !== $this->model->validateNames($fullname)) {
                $_SESSION['errorActualizacion'] = "Caraceteres no válidos en el campo nombre";
                header('Location: /perfil');
                exit();
            }

            if (!$this->model->validateGender($gender)) {
                $_SESSION['errorActualizacion'] = "El género no es válido";
                header('Location: /perfil');
                exit();
            }

            if ($country !== $this->model->validateNames($country)) {
                $_SESSION['errorActualizacion'] = "Caraceteres no válidos en el campo país";
                header('Location: /perfil');
                exit();
            }

            $profilePic = $this->profilePicHandler->handleProfilePic();
            $idUsuario = $this->model->getUserByUsernameOrEmail($_SESSION['user'],'a')['id_usuario'];

            $success = $this->model->updateUser(
                $fullname, $gender, $country, $profilePic, $idUsuario);

            if ($success) {
                header('Location: /perfil');
                exit();
            } else {
                $message = "Error al actualizar los datos del usuario.";
            }
        }

        $this->presenter->show('/perfil', ['message' => $message]);
    }
}