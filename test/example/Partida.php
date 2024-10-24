<?php

class Partida
{
    private $id;
    private $fechaHora;
    private $puntaje;
    private $estado;
    private $idUsuario;
    
    public function __construct()
    {
        $this->fechaHora = date('Y-m-d H:i:s');
        $this->puntaje = 0;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getFechaHora()
    {
        return $this->fechaHora;
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
    
    public function getEstado()
    {
        return $this->estado;
    }
    
    public function setIdUsuario(int $idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }
    
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
}
