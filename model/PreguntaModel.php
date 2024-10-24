<?php


class PreguntaModel
{
    
    
    private $db;
    
    
    public function __construct($database)
    {
        $this->db = $database;
    }
    
    
    public function saveEstado($estado)
    {
        
        $query = $this->db->prepare("INSERT INTO estado (
                    id_estado,
                descripcion_estado
                ) VALUES (?, ?)");
        
        $descripcion_estado = $estado->getDescripcion();
        $id_estado = $estado->getId();
        
        $query->bind_Param("is", $id_estado, $descripcion_estado);
        return $query->execute();
        
        
    }
    
    
    public function saveCategoria($categoria)
    {
        $query = $this->db->prepare("INSERT INTO categoria (
                    id_categoria,
                descripcion_categoria,
                       img_categoria,
                       color_categoria
                ) VALUES (?,?,?,?)");
        
        $id_categoria = $categoria->getIdCategoria();
        $descripcion_categoria = $categoria->getDescripcion();
        $img_categoria = $categoria->getImg();
        $color_categoria = $categoria->getColor();
        
        $query->bind_Param("isss", $id_categoria, $descripcion_categoria,$img_categoria,$color_categoria);
        return $query->execute();
        
        
        
    }
    
    public function savePregunta($pregunta)
    {
        
        $query = $this->db->prepare("INSERT INTO pregunta (
                    id_pregunta,
                interrogante_pregunta,
                      fechaCreacion_pregunta,
                      id_usuarioCreador,
                       id_categoria,
                       id_estado
                ) VALUES (?,?,?,?,?,?)");
        
        
        $fecha = date("Y-m-d");
        $pregunta->setFechaCreacionPregunta($fecha);
        
        
        $id_pregunta = $pregunta->getIdPregunta();
        $interrogante_pregunta = $pregunta->getInterrogantePregunta();
        $fechaCreacion_pregunta = $pregunta->getFechaCreacionPregunta();
        
        $id_usuarioCreador = $pregunta->getIdUsuarioCreador();
        
        $id_categoria = $pregunta->getIdCategoria();
        $id_estado = $pregunta->getIdEstado();
        
        
        
        $query->bind_Param("isdiii", $id_pregunta,$interrogante_pregunta,$fechaCreacion_pregunta,$id_usuarioCreador,$id_categoria,$id_estado);
        return $query->execute();
    }
    
    public function obtenerPreguntaPorId($id)
    {
        
        $query = $this->db->prepare("SELECT * FROM Pregunta WHERE id_pregunta = ?");
        $query->bind_param('i', $id);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC);
        
    }
    
    public function obtenerCategoriaPorId( $id)
    {
        
        $query = $this->db->prepare("SELECT * FROM Categoria WHERE id_categoria = ?");
        $query->bind_param('i', $id);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC);
        
    }
    
    public function obtenerEstadoPorId($id)
    {
        
        $query = $this->db->prepare("SELECT * FROM Estado WHERE id_estado = ?");
        $query->bind_param('i', $id);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC);
        
        
    }
    
    
}