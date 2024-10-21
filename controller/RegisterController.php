<?php


class RegisterController
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
        $this->presenter->show('register', []);
    }

    public function registerUser()
    {
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $fullname = $_POST['fullname'] ?? '';
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $repeat_password = $_POST['repeat_pass'] ?? '';
            $birthYear = $_POST['birth_year'] ?? '';
            $gender = $_POST['gender'] ?? '';
            $country = $_POST['country'] ?? '';
            $city = $_POST['city'] ?? '';

            if ($fullname !== $this->model->validateNames($fullname)) {
                $message = "Caraceteres no válidos en el campo nombre";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if ($username !== $this->model->validateUsername($username)) {
                $message = "El nombre de usuario no es válido";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if ($this->model->usernameExists($username)) {
                $message = "El nombre de usuario ya está en uso";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if ($email !== $this->model->validateEmail($email)) {
                $message = "El correo electrónico no es válido";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if ($this->model->emailExists($email)) {
                $message = "El email ya está en uso";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if ($password !== $this->model->validatePassword($password)) {
                $message = "La contraseña no es válida";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if ($password !== $repeat_password) {
                $message = "Las contraseñas no coinciden";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if ($birthYear !== $this->model->validateDate($birthYear)) {
                $message = "La fecha de nacimiento no es válida";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if (!$this->model->validateGender($gender)) {
                $message = "El género no es válido";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if ($country !== $this->model->validateNames($country)) {
                $message = "Caraceteres no válidos en el campo país";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            if ($city !== $this->model->validateNames($city)) {
                $message = "Caraceteres no válidos en el campo ciudad";
                $this->presenter->show('/register', ['message' => $message]);
                return;
            }

            $profilePic = $this->profilePicHandler->handleProfilePic();

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
}