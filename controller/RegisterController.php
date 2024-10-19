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


            $fullname = isset($_POST['fullname']) && preg_match('/[^a-z\s-]/',$_POST['fullname']) != 0 ? $_POST['fullname'] : '';
            $username = isset($_POST['username']) && preg_match('/\W/',$_POST['username']) == 0 ? $_POST['username'] : '';
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $password = isset($_POST['password']) && preg_match('/\s/',$_POST['password']) == 0 ? $_POST['password'] : '';
            $repeat_password = isset($_POST['repeat_pass']) && preg_match('/\s/',$_POST['repeat_pass']) == 0 ? $_POST['repeat_pass'] : '';
            $birthYear = isset($_POST['birth_year']) && preg_match('/^\d{4}-\d{2}-\d{2}$/',$_POST['birth_year']) ? $_POST['birth_year'] : '';
            $gender = $this->isValidGender($_POST['gender']) ? $_POST['gender'] : '';
            $country = isset($_POST['country']) && preg_match('/[^a-z\s-]/',$_POST['country']) != 0 ? $_POST['country'] : '';
            $city = isset($_POST['city']) && preg_match('/[^a-z\s-]/',$_POST['city']) != 0 ? $_POST['city'] : '';;

            if (strcmp($fullname, '')==0) {
                $message = "El nombre no es válido.";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if (strcmp($username,'')==0) {
                $message = "El nombre de usuario no es válido.";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if (!$email) {
                $message = "Email no es valido.";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if (strcmp($password,'')==0) {
                $message = "La contraseña no es válida.";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if (strcmp($birthYear,'')==0) {
                $message = "La fecha de nacimiento no es válida.";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if (strcmp($gender,'')==0) {
                $message = "El género no es válido.";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if (strcmp($country,'')==0) {
                $message = "Caracteres no válidos en campo país.";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if (strcmp($city,'')==0) {
                $message = "Caracteres no válidos en campo ciudad.";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

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

    private function isValidGender($gender)
    {
        return $this->model->validateGender($gender);
    }
}