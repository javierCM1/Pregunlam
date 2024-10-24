<?php

class Estado
{

    private static $contador_id = 0; // Variable estática para mantener el contador de IDs
    private $id;
    private $descripcion;
    
    
    
    public function __construct()
    {
        self::$contador_id++; // Incrementa el contador estático
        $this->id = self::$contador_id; // Asigna el ID autoincremental
        
        $this->descripcion = null;
        
    }
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }
    
    public function setIdEstado(int $int)
    {
        $this->id = $int;
    }
    
    public function setDescripcion(string $string)
    {
        $this->descripcion = $string;
    }
}
