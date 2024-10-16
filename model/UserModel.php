<?php

class UserModel
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function emailExists($email)
    {
        $query = $this->db->prepare("SELECT * FROM usuario WHERE mail_usuario = ?");
        $query->bind_param('s', $email);
        $query->execute();
        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        return !empty($result);
    }

    public function usernameExists($username)
    {
        $query = $this->db->prepare("SELECT * FROM usuario WHERE userName_usuario = ?");
        $query->bind_param('s', $username);
        $query->execute();
        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        return !empty($result);
    }

    public function register($fullname, $username, $email, $password, $birthday, $gender, $country, $city, $profilePic)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $defaultUserType = 3;

        $query = $this->db->prepare("INSERT INTO usuario (
            nombreCompleto_usuario, 
            userName_usuario, 
            mail_usuario, 
            password_usuario, 
            fechaNacimiento_usuario, 
            id_sexo, 
            pais_usuario, 
            img_usuario, 
            fechaRegistro_usuario, 
            estado_usuario, 
            id_tipo_usuario
        ) VALUES (?, ?, ?, ?, ?, (SELECT id_sexo FROM sexo WHERE descripcion_sexo = ?), ?, ?, NOW(), 'A', ?)");

        $query->bind_param('ssssssssi', $fullname, $username, $email, $hashedPassword, $birthday, $gender, $country, $profilePic, $defaultUserType);
        return $query->execute();
    }

    public function validateLogin($username, $password)
    {

        $query = $this->db->prepare("SELECT password_usuario FROM usuario WHERE userName_usuario = ? OR mail_usuario = ?");
        $query->bind_param('ss', $username, $username);
        $query->execute();

        $result = $query->get_result()->fetch_assoc();

        if ($result && password_verify($password, $result['password_usuario'])) {
            return true;
        }

        return false;
    }
}
