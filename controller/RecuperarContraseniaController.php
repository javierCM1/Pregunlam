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
    
    public function index()
    {
        $this->presenter->show('recuperarContrasenia', []);
    }
    
    public function recuperar()
    {
        $email = $_POST['email'] ?? '';
        $user = $_POST['username'] ?? '';
        $newPassword = $_POST['password'] ?? '';
        
        $this->inputFormatValidator->validateUsername($user);
        $this->inputFormatValidator->validateEmail($email);
        $this->inputFormatValidator->validatePassword($newPassword);
        
        $userData = $this->model->getUserByUsernameAndEmail($user, $email, 'a');
        if ($userData) {
            $this->model->updatePassword($userData['id_usuario'], $newPassword);
            
            $message = 'Tu contraseña ha sido actualizada correctamente.';
            $this->presenter->show('login', ['message' => $message]);
        } else {
            $message = 'No se encontró el usuario o correo electrónico.';
            $this->presenter->show('recuperarContrasenia', ['message' => $message]);
        }
    }
    
    
}
