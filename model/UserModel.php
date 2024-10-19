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

    public function getUserByUsernameOrEmail($usernameOrEmail, $state)
    {
        $query = $this->db->prepare("SELECT * FROM usuario WHERE (userName_usuario = ? OR email_usuario = ?) AND estado_usuario = ?");
        $query->bind_param('sss', $usernameOrEmail, $usernameOrEmail, $state);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC);
    }

    public function validateData($fullname, $username, $email, $password, $repeat_password, $birthYear, $gender, $country, $city)
    {
        $message = '';

        $fullname = preg_match('/^[a-zA-Z\s-]+$/',$fullname) == 1 ? $fullname : '';
        $username = preg_match('/\W/',$username) == 0 ? $username : '';
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        $password = preg_match('/\s/',$password) == 0 ? $password : '';
        $repeat_password = preg_match('/\s/',$repeat_password) == 0 ? $repeat_password : '';
        $birthYear = preg_match('/^\d{4}-\d{2}-\d{2}$/',$birthYear) ? $birthYear : '';
        $gender = $this->validateGender($gender) ? $gender : '';
        $country = preg_match('/^[a-zA-Z\s-]+$/',$country) == 1 ? $country : '';
        $city = preg_match('/^[a-zA-Z\s-]+$/',$city) == 1 ? $city : '';
        
        if (strcmp($fullname, '')==0)
            $message = "El nombre no es válido.";

        if (strcmp($username,'')==0)
            $message = "El nombre de usuario no es válido.";

        if (!$email)
            $message = "Email no es valido.";

        if (strcmp($password,'')==0 || strcmp($repeat_password,'')==0)
            $message = "La contraseña no es válida.";

        if (strcmp($birthYear,'')==0)
            $message = "La fecha de nacimiento no es válida.";

        if (strcmp($gender,'')==0)
            $message = "El género no es válido.";

        if (strcmp($country,'')==0)
            $message = "Caracteres no válidos en campo país.";

        if (strcmp($city,'')==0)
            $message = "Caracteres no válidos en campo ciudad.";

        return $message;
    }

    public function register($fullname, $username, $email, $password, $birthday, $gender, $country, $city, $profilePic)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $defaultUserType = 3;
        $defaultState = 'p';
        $token = random_int(100000,999999);

        $genero = "$gender";
        $idSexo = $this->db->prepare("SELECT id_sexo FROM sexo WHERE descripcion_sexo LIKE ?");
        $idSexo->bind_param('s', $genero);
        $idSexo->execute();
        $idSexoResult = $idSexo->get_result()->fetch_array(MYSQLI_ASSOC)['id_sexo'];

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

        $query->bind_param('ssssssssiii', $username, $hashedPassword, $email, $profilePic, $fullname, $birthday,
            $country, $defaultState, $token, $defaultUserType, $idSexoResult);

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

    public function validateGender($gender)
    {
        $query = $this->db->prepare("SELECT 1 FROM sexo WHERE descripcion_sexo = ?");
        $query->bind_param('s', $gender);
        $query->execute();
        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        return !empty($result);
    }
}
