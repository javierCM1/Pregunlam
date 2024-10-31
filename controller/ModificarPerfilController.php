<?php

class ModificarPerfilController
{
    private $model;
    private $presenter;
    private $profilePicHandler;
    private $inputFormatValidator;

    public function __construct($model, $presenter, $profilePicHandler, $inputFormatValidator)
    {
        $this->model = $model;
        $this->presenter = $presenter;
        $this->profilePicHandler = $profilePicHandler;
        $this->inputFormatValidator = $inputFormatValidator;
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $data['usuario'] = $this->model->getUserByUsernameOrEmail($_SESSION['user'],'a');
        $id = isset($_GET['id']) ? (int)$_GET['id'] : $data['usuario']['id_usuario'];
        $coordenada = $data['usuario']['pais_usuario'];
        $coordenada = explode(",", $coordenada);
        $data['lat'] = floatval($coordenada[0]);
        $data['lng'] = floatval($coordenada[1]);

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
        try {
            $message = '';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $fullname = $_POST['fullname'] ?? '';
                $gender = $_POST['gender'] ?? '';
                $country = $_POST['coordenadas'] ?? '';

                $this->inputFormatValidator->validateNames($fullname);
                $this->model->validateGender($gender);

                $profilePic = $this->profilePicHandler->handleProfilePic();
                $idUsuario = $this->model->getUserByUsernameOrEmail($_SESSION['user'],'a')['id_usuario'];

                $success = $this->model->updateUser($fullname, $gender, $country, $profilePic, $idUsuario);

                if ($success) {
                    header('Location: /perfil');
                    exit();
                } else {
                    $message = "Error al actualizar los datos del usuario.";
                }
            }

            $this->presenter->show('/perfil', ['message' => $message]);
        }
        catch (Exception $e) {
            $_SESSION['errorActualizacion'] = $e->getMessage();
            header('Location: /perfil');
            exit();
        }
    }
}