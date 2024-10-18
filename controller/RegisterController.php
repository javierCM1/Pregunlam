<?php


class RegisterController
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
        $this->presenter->show('register', []);
    }

    public function registerUser()
    {
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            $fullname = $_POST['fullname'];
            $username = isset($_POST['username']) && !preg_match('/\W/',$_POST['username']) ? $_POST['username'] : '';
            $email = $_POST['email'];
            $password = $_POST['password'];
            $repeat_password = $_POST['repeat_pass'];
            $birthYear = $_POST['birth_year'];
            $gender = $_POST['gender'];
            $country = $_POST['country'];
            $city = $_POST['city'];

            if ($password !== $repeat_password) {
                $message = "Las contraseñas no coinciden.";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if ($this->model->emailExists($email)) {
                $message = "El email ya está registrado.";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if ($this->model->usernameExists($username)) {
                $message = "El nombre de usuario ya está en uso.";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if (strcmp($username,'')==0) {
                $message = "El nombre de usuario es incorrecto.";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            $profilePic = $this->handleProfilePic();

            $success = $this->model->register(
                $fullname, $username, $email, $password,
                $birthYear, $gender, $country, $city, $profilePic
            );

            if ($success) {
                header('Location: /login');
                exit();
            } else {
                $message = "Error al registrar usuario.";
            }
        }


        $this->presenter->show('/register', ['message' => $message]);
    }

    private function handleProfilePic()
    {
        $uploadDirectory = 'public/images/fotoDePerfil/';
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
            $profilePic = $uploadDirectory . basename($_FILES['profile_pic']['name']);
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profilePic)) {
                return $profilePic;
            }
        }
        return '';
    }
}