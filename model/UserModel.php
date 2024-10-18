<?php

class UserModel
{
    private $db;

    private $fileEmailSender;

    public function __construct($database, $fileEmailSender)
    {
        $this->db = $database;
        $this->fileEmailSender = $fileEmailSender;
    }

    public function emailExists($email)
    {
        $query = $this->db->prepare("SELECT 1 FROM usuario WHERE email_usuario = ?");
        $query->bind_param('s', $email);
        $query->execute();
        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        return !empty($result);
    }

    public function usernameExists($username)
    {
        $query = $this->db->prepare("SELECT 1 FROM usuario WHERE userName_usuario = ?");
        $query->bind_param('s', $username);
        $query->execute();
        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        return !empty($result);
    }

    public function getUserById($id)
    {
        $query = $this->db->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
        $query->bind_param('i', $id);
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserByUsernameOrEmail($usernameOrEmail)
    {
        $estadoActivo = 'a';
        $query = $this->db->prepare("SELECT * FROM usuario WHERE userName_usuario = ? OR email_usuario = ? AND estado_usuario = ?");
        $query->bind_param('sss', $usernameOrEmail, $usernameOrEmail, $estadoActivo);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC);
    }

    public function register($fullname, $username, $email, $password, $birthday, $gender, $country, $city, $profilePic)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $defaultUserType = 3;
        $defaultState = 'p';
        $genero = "'%$gender%'";
        $token = random_int(100000,999999);

        $idSexo = $this->db->prepare("SELECT `id_sexo` FROM sexo WHERE `descripcion_sexo` LIKE ?");
        $idSexo->bind_param('s', $genero);
        $idSexo = $idSexo->execute();

        $query = $this->db->prepare("INSERT INTO usuario (
                    `userName_usuario`, 
                    `password_usuario`, 
                    `email_usuario`,
                    `img_usuario`, 
                    `nombreCompleto_usuario`, 
                    `fechaNacimiento_usuario`, 
                    `pais_usuario`, 
                    `fechaRegistro_usuario`, 
                    `estado_usuario`, 
                    `token_usuario`, 
                    `id_tipo_usuario`, 
                    `id_sexo`
        ) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?)");

        $query->bind_param('ssssssssiis', $username, $hashedPassword, $email, $profilePic, $fullname, $birthday,
            $country, $defaultState, $token, $defaultUserType, $idSexo);

        if($query->execute()){
            $this->fileEmailSender->sendEmailToFile('C:\xampp\htdocs\Pregunlam\dev.log', 'Activar cuenta', $fullname .", presiona <a href='http://localhost/activar/auth?username=$username&token=$token'>aquí</a> para activar la cuenta con el siguiente código: ". $token ."\r\n");
            return true;
        }

        return false;
    }

    public function validateLogin($username, $password, $estado)
    {
        $query = $this->db->prepare("SELECT password_usuario FROM usuario WHERE estado_usuario = ? AND (userName_usuario = ? OR email_usuario = ?)");
        $query->bind_param('sss', $estado, $username, $username);
        $query->execute();

        $result = $query->get_result()->fetch_assoc();

        return $result && password_verify($password, $result['password_usuario']);
    }

    public function validateActivation($username, $token)
    {
        $nuevoEstado = 'a';
        $query = $this->db->prepare("UPDATE usuario SET estado_usuario = ? WHERE userName_usuario = ? AND token_usuario = ?");
        $query->bind_param('ssi', $nuevoEstado, $username, $token);
        return $this->db->executeStmt($query) == 1;
    }
}
