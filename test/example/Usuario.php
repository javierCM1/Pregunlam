<?php

class Usuario
{
    
    private static $contador_id;
    private $id ;
    private $userName_usuario;
    private $password_usuario;
    private $mail_usuario;
    private $img_usuario;
    private $maxPuntaje_usuario;
    private $nombreCompleto_usuario;
    private $fechaNac_usuario;
    private $pais_usuario;
    private $fechaReg_usuario;
    private $estado_usuario;
    private $cantPregJugadas;
    private $cantPregCorrectas;
    private $id_tipo_usuario;
    private $id_sexo;
    
    public function __construct()
    {
        
        self::$contador_id++; // Incrementa el contador estático
        $this->id = self::$contador_id; // Asigna el ID autoincremental
    }
    
    // Getters
    public function getIdUsuario(): int {
        return $this->id;
    }
    
    public function getUserNameUsuario(): string {
        return $this->userName_usuario;
    }
    
    public function getPasswordUsuario(): string {
        return $this->password_usuario;
    }
    
    public function getMailUsuario(): string {
        return $this->mail_usuario;
    }
    
    public function getImgUsuario(): string {
        return $this->img_usuario;
    }
    
    public function getMaxPuntajeUsuario(): int {
        return $this->maxPuntaje_usuario;
    }
    
    public function getNombreCompletoUsuario(): string {
        return $this->nombreCompleto_usuario;
    }
    
    public function getFechaNacUsuario(): string {
        return $this->fechaNac_usuario;
    }
    
    public function getPaisUsuario(): string {
        return $this->pais_usuario;
    }
    
    public function getFechaRegUsuario(): string {
        return $this->fechaReg_usuario;
    }
    
    public function getEstadoUsuario(): string {
        return $this->estado_usuario;
    }
    
    public function getCantPregJugadas(): int {
        return $this->cantPregJugadas;
    }
    
    public function getCantPregCorrectas(): int {
        return $this->cantPregCorrectas;
    }
    
    public function getIdTipoUsuario(): int {
        return $this->id_tipo_usuario;
    }
    
    public function getIdSexo(): int {
        return $this->id_sexo;
    }
    
    /**
     * @param mixed $contador_id
     */
    public static function setContadorId($contador_id): void
    {
        self::$contador_id = $contador_id;
    }
    
    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }
    
    /**
     * @param mixed $userName_usuario
     */
    public function setUserNameUsuario($userName_usuario): void
    {
        $this->userName_usuario = $userName_usuario;
    }
    
    /**
     * @param mixed $password_usuario
     */
    public function setPasswordUsuario($password_usuario): void
    {
        $this->password_usuario = $password_usuario;
    }
    
    /**
     * @param mixed $mail_usuario
     */
    public function setMailUsuario($mail_usuario): void
    {
        $this->mail_usuario = $mail_usuario;
    }
    
    /**
     * @param mixed $img_usuario
     */
    public function setImgUsuario($img_usuario): void
    {
        $this->img_usuario = $img_usuario;
    }
    
    /**
     * @param mixed $maxPuntaje_usuario
     */
    public function setMaxPuntajeUsuario($maxPuntaje_usuario): void
    {
        $this->maxPuntaje_usuario = $maxPuntaje_usuario;
    }
    
    /**
     * @param mixed $nombreCompleto_usuario
     */
    public function setNombreCompletoUsuario($nombreCompleto_usuario): void
    {
        $this->nombreCompleto_usuario = $nombreCompleto_usuario;
    }
    
    /**
     * @param mixed $fechaNac_usuario
     */
    public function setFechaNacUsuario($fechaNac_usuario): void
    {
        $this->fechaNac_usuario = $fechaNac_usuario;
    }
    
    /**
     * @param mixed $pais_usuario
     */
    public function setPaisUsuario($pais_usuario): void
    {
        $this->pais_usuario = $pais_usuario;
    }
    
    /**
     * @param mixed $fechaReg_usuario
     */
    public function setFechaRegUsuario($fechaReg_usuario): void
    {
        $this->fechaReg_usuario = $fechaReg_usuario;
    }
    
    /**
     * @param mixed $estado_usuario
     */
    public function setEstadoUsuario($estado_usuario): void
    {
        $this->estado_usuario = $estado_usuario;
    }
    
    /**
     * @param mixed $cantPregJugadas
     */
    public function setCantPregJugadas($cantPregJugadas): void
    {
        $this->cantPregJugadas = $cantPregJugadas;
    }
    
    /**
     * @param mixed $cantPregCorrectas
     */
    public function setCantPregCorrectas($cantPregCorrectas): void
    {
        $this->cantPregCorrectas = $cantPregCorrectas;
    }
    
    /**
     * @param mixed $id_tipo_usuario
     */
    public function setIdTipoUsuario($id_tipo_usuario): void
    {
        $this->id_tipo_usuario = $id_tipo_usuario;
    }
    
    /**
     * @param mixed $id_sexo
     */
    public function setIdSexo($id_sexo): void
    {
        $this->id_sexo = $id_sexo;
    }
    
    
    
    
    
}