<?php

class Categoria
{
    
   
    private $idCategoria;
    private $color;
    private $img;
    private $descripcion;
    
    public function __construct()
    {
    }
    
    public function setIdCategoria(int $int)
    {
        $this->idCategoria = $int;
    }
    
    public function setDescripcion(string $string)
    {
        $this->descripcion = $string;
    }
    
    public function getIdCategoria(){
        return $this->idCategoria;
    }
    
    public function getDescripcion(){
        return $this->descripcion;
    }
    
    public function getImg(){
        return $this->img;
    }
    
    public function getColor(){
        return $this->color;
    }
    
    public function setColor($color): void
    {
        $this->color = $color;
    }
    
    public function setImg($img): void
    {
        $this->img = $img;
    }
    
    
    
    
    
    
    
    
    
    
}