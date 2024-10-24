<?php

class Pregunta
{
    private $id_pregunta;
    private $interrogante_pregunta;
    private $id_categoria;
    private $id_estado;
    
    private $fechaCreacion_pregunta;

    private $id_usuarioCreador;
    
    public function __construct()
    {
    }
    
  
    public function getIdPregunta()
    {
        return $this->id_pregunta;
    }
    
  
    public function setIdPregunta($id_pregunta): void
    {
        $this->id_pregunta = $id_pregunta;
    }
    
  
    public function getInterrogantePregunta()
    {
        return $this->interrogante_pregunta;
    }
    
  
    public function setInterrogantePregunta($interrogante_pregunta): void
    {
        $this->interrogante_pregunta = $interrogante_pregunta;
    }
    
 
    public function getIdCategoria()
    {
        return $this->id_categoria;
    }
    
  
    public function setIdCategoria($id_categoria): void
    {
        $this->id_categoria = $id_categoria;
    }
    
 
    public function getIdEstado()
    {
        return $this->id_estado;
    }
   
    public function setIdEstado($id_estado): void
    {
        $this->id_estado = $id_estado;
    }



    public function getFechaCreacionPregunta()
    {
        return $this->fechaCreacion_pregunta;
    }
    public function setFechaCreacionPregunta($fechaCreacion_pregunta): void
    {
        $this->fechaCreacion_pregunta = $fechaCreacion_pregunta;
    }
    
    
    public function getIdUsuarioCreador()
    {
        return $this->id_usuarioCreador;
    }
    
   
    public function setIdUsuarioCreador($id_usuarioCreador): void
    {
        $this->id_usuarioCreador = $id_usuarioCreador;
    }
    
    
    
    
    
}