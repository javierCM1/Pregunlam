<?php

class RegisterController
{
    private $model;
    private $presenter;
    private $profilePicHandler;
    private $fileEmailSender;
    private $inputFormatValidator;
    
    public function __construct($model, $presenter, $profilePicHandler, $fileEmailSender, $inputFormatValidator)
    {
        $this->model = $model;
        $this->presenter = $presenter;
        $this->profilePicHandler = $profilePicHandler;
        $this->fileEmailSender = $fileEmailSender;
        $this->inputFormatValidator = $inputFormatValidator;
    }
    
    public function index()
    {
        $this->presenter->show('register', []);
    }
    
    public function registerUser()
    {
        try {
            $message = '';
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $fullname = $_POST['fullname'] ?? '';
                $username = $_POST['username'] ?? '';
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';
                $repeat_password = $_POST['repeat_pass'] ?? '';
                $birthYear = $_POST['birth_year'] ?? '';
                $gender = $_POST['gender'] ?? '';
                $country = $_POST['coordenadas'] ?? '-34.670554,-58.562810';
                
                // Validación de los campos de entrada
                $this->inputFormatValidator->validateNames($fullname);
                $this->inputFormatValidator->validateUsername($username);
                $this->inputFormatValidator->validateEmail($email);
                $this->inputFormatValidator->validatePassword($password);
                $this->inputFormatValidator->validateDate($birthYear);
                $this->model->validateGender($gender);
                $this->model->usernameExists($username);
                
                // Validación de la edad mínima (10 años)
                $currentYear = date('Y');
                if (!is_numeric($birthYear) || ($currentYear - $birthYear) < 10) {
                    $message = "Eres menor de 10 años y no puedes registrarte.";
                    $this->presenter->show('register', ['message' => $message]);
                    return;
                }
                
                
                // Verificar que las contraseñas coincidan
                if ($password !== $repeat_password) {
                    $message = "Las contraseñas no coinciden";
                    $this->presenter->show('register', ['message' => $message]);
                    return;
                }
                
                // Manejar la foto de perfil y generar token
                $profilePic = $this->profilePicHandler->handleProfilePic();
                $token = random_int(100000, 999999);
                
                // Registro del usuario
                $success = $this->model->register(
                    $fullname, $username, $email, $password,
                    $birthYear, $gender, $country, $profilePic, $token
                );
                
                if ($success) {
                    $mensaje = $fullname . ", presiona <a href='http://localhost/activar/auth?username=$username&token=$token'>aquí</a> para activar la cuenta con el siguiente código: " . $token;
                    $this->fileEmailSender->sendEmail('ivan.landin24@gmail.com', $email, 'Activar cuenta', $mensaje);
                    header('Location: /login');
                    exit();
                } else {
                    $message = "Error al registrar usuario.";
                }
            }
            
            $this->presenter->show('register', ['message' => $message]);
        } catch (Exception $e) {
            $message = $e->getMessage();
            $this->presenter->show('register', ['message' => $message]);
        }
    }
}
