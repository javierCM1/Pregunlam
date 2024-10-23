<?php

class Partida
{
    
    private static $contador_id;
    private $id;
   
    private $fechaHora;
  
    private $puntaje;
 
    private $estado;
 
    private $idUsuario;
    
    public function __construct()
    {
        self::$contador_id++; // Incrementa el contador estático
        $this->id = self::$contador_id; // Asigna el ID autoincremental
        $this->fechaHora = date('Y-m-d H:i:s');
        $this->puntaje = 0;
        
    }
    
    public function getId(){
        return $this->id;
    }
    
    
    public function getFechaHora(){
        return $this->fechaHora;
    }
    
    /**
     * @return mixed
     */
    public static function getContadorId()
    {
        return self::$contador_id;
    }
    
    /**
     * @param mixed $contador_id
     */
    public static function setContadorId($contador_id)
    {
        self::$contador_id = $contador_id;
    }
    
    public function getPuntaje(): int
    {
        return $this->puntaje;
    }
    
    public function setPuntaje(int $puntaje)
    {
        $this->puntaje = $puntaje;
    }
    
    public function setEstado(string $estado)
    {
        $this->estado = $estado;
    }
    
    public function getEstado(){
        return $this->estado;
    }
    
    public function setIdUsuario(int $idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }
    
    public function getIdUsuario(){
        return $this->idUsuario;
    }
    
    
}