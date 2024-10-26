<?php



class UserModel
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    /**
     * @throws EmailExistsException
     */
    public function emailExists($email)
    {
        $query = $this->db->prepare("SELECT 1 FROM usuario WHERE email_usuario = ?");
        $query->bind_param('s', $email);
        $query->execute();
        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        if(empty($result))
            return false;
        throw new EmailExistsException();
    }

    /**
     * @throws UsernameExistsException
     */
    public function usernameExists($username)
    {
        $query = $this->db->prepare("SELECT 1 FROM usuario WHERE userName_usuario = ?");
        $query->bind_param('s', $username);
        $query->execute();
        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        if(empty($result))
            return false;
        throw new UsernameExistsException();
    }

    public function getUserById($id)
    {
        $query = $this->db->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
        $query->bind_param('i', $id);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC);
    }

    public function getUserProfileById($id)
    {
        $estadoActivo = 'a';
        $query = $this->db->prepare("SELECT id_usuario, userName_usuario, maxPuntaje_usuario, img_usuario, pais_usuario
                                    FROM usuario WHERE id_usuario = ? AND estado_usuario = ?");
        $query->bind_param('is', $id, $estadoActivo);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC);
    }

    public function getUserByUsernameOrEmail($usernameOrEmail, $state)
    {
        $query = $this->db->prepare("SELECT * FROM usuario WHERE (userName_usuario = ? OR email_usuario = ?) AND estado_usuario = ?");
        $query->bind_param('sss', $usernameOrEmail, $usernameOrEmail, $state);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC);
    }

    /**
     * @throws InvalidGenderException
     */
    public function validateGender($gender)
    {
        return !empty($this->getIdSexo($gender)) ?? throw new InvalidGenderException();
    }

    public function register($fullname, $username, $email, $password, $birthday, $gender, $country, $city, $profilePic, $token)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $defaultUserType = 3;
        $defaultState = 'p';
        $idSexoResult = $this->getIdSexo($gender);

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

        return $query->execute();
    }

    public function updateUser($fullname, $gender, $country, $profilePic, $id_usuario)
    {
        $idSexoResult = $this->getIdSexo($gender);

        if($profilePic === '') {
            $profilePic = $this->getUserById($id_usuario)['img_usuario'];
        }

        $query = $this->db->prepare("UPDATE usuario SET
                    `img_usuario` = ?,
                    `nombreCompleto_usuario` = ?,
                    `pais_usuario` = ?,
                    `id_sexo` = ?
                    WHERE id_usuario = ?");

        $query->bind_param('sssii', $profilePic, $fullname, $country, $idSexoResult, $id_usuario);

        return $query->execute();
    }

    private function getIdSexo($gender)
    {
        $genero = "$gender";
        $query = $this->db->prepare("SELECT id_sexo FROM sexo WHERE descripcion_sexo LIKE ?");
        $query->bind_param('s', $genero);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC)['id_sexo'];
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

    public function incrementarCantPreguntasJugadas($idUsuario)
    {
        $estado = 'a';
        $incrementoPreguntasJugadas = 1;
        $query = $this->db->prepare("UPDATE `usuario` SET `cantPreguntasJugadas_usuario`= `cantPreguntasJugadas_usuario` + ? 
                                    WHERE id_usuario = ? AND estado_usuario = ?");
        $query->bind_param('iis',$incrementoPreguntasJugadas,$idUsuario,$estado);
        return $query->execute();
    }

    public function determinarPuntajeMaximo($usuario,$partida)
    {
        if($usuario['maxPuntaje_usuario'] < $partida['puntaje_partida']){
            $estado = 'a';
            $query = $this->db->prepare("UPDATE `usuario` SET `maxPuntaje_usuario` = ? 
                                        WHERE id_usuario = ? AND estado_usuario = ?");
            $query->bind_param('iis',$partida['puntaje_partida'],$usuario['id_usuario'],$estado);
            return $query->execute();
        }
        return false;
    }

}
