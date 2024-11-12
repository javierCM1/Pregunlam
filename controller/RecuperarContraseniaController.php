<?php

class RecuperarContraseniaController
{
    private $model;
    private $presenter;
 
  
    private $inputFormatValidator;
    
    public function __construct($model, $presenter,$inputFormatValidator)
    {
        $this->model = $model;
        $this->presenter = $presenter;
        $this->inputFormatValidator = $inputFormatValidator;
        
    }
    
    // Mostrar el formulario para ingresar el correo electrónico
    public function index()
    {
        $this->presenter->show('recuperarContrasenia', []);
    }
    
    // Procesar la solicitud de recuperación de contraseña
    public function recuperar()
    {
        // Obtenemos los datos del formulario
        $email = $_POST['email'] ?? '';
        $user = $_POST['username'] ?? '';
        $newPassword = $_POST['password'] ?? '';
        
        // Realizamos las validaciones para el nombre de usuario y el correo
        $this->inputFormatValidator->validateUsername($user);
        $this->inputFormatValidator->validateEmail($email);
        $this->inputFormatValidator->validatePassword($newPassword);
        
        // Verificamos si el usuario existe y está activo en la base de datos
        $userData = $this->model->getUserByUsernameAndEmail($user, $email, 'a'); // Estado 'a' para activos
        if ($userData) {
            // La validación fue exitosa, proceder con la actualización de la contraseña
            $this->model->updatePassword($userData['id_usuario'], $newPassword); // Llamar al modelo para actualizar la contraseña
            
            $message = 'Tu contraseña ha sido actualizada correctamente.';
            $this->presenter->show('login', ['message' => $message]);
        } else {
            // El usuario o el correo no coinciden
            $message = 'No se encontró el usuario o correo electrónico.';
            $this->presenter->show('recuperarContrasenia', ['message' => $message]);
        }
    }
    
    
}
