<?php

class Usuario
{
    
    private static $contador_id;
    private $id;
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
        return $this->id_usuario;
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
    
    
    
}