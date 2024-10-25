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
    
    public function obtenerPreguntaPorId($id,$estado)
    {
        $query = $this->db->prepare("SELECT P.id_pregunta,
                                            P.interrogante_pregunta,
                                            P.fechaCreacion_pregunta,
                                            P.cantVistas_pregunta,
                                            P.cantCorrectas_pregunta,
                                            C.descripcion_categoria,
                                            C.img_categoria,
                                            C.color_categoria,
                                            E.descripcion_estado,
                                            U.userName_usuario FROM Pregunta P
                                                                   JOIN Categoria C ON P.id_categoria=C.id_categoria
                                                                   JOIN Estado E ON P.id_estado=E.id_estado
                                                                   JOIN Usuario U ON P.id_usuarioCreador=U.id_usuario
                                                                   WHERE P.id_pregunta = ? AND P.id_estado = ?");
        $query->bind_param('ii', $id,$estado);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC);
    }
    
    

    public function getRespuestasPorIdPregunta($idPregunta)
    {
        $query = $this->db->prepare("SELECT * FROM respuesta WHERE id_pregunta = ?");
        $query->bind_param('i', $idPregunta);
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
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

    public function incrementarCantVistas($id_pregunta, $estadoPregunta)
    {
        $incrementoVistas = 1;
        $query = $this->db->prepare("UPDATE `pregunta` SET `cantVistas_pregunta`= `cantVistas_pregunta` + ?
                                    WHERE id_pregunta = ? AND id_estado = ?");
        $query->bind_param('iii',$incrementoVistas,$id_pregunta,$estadoPregunta);
        return $query->execute();
    }

    public function establecerPreguntaVista($idUsuario,$id_pregunta)
    {
        $query = $this->db->prepare("INSERT INTO `pregunta_vista`(
                                        `id_usuario`,
                                        `id_pregunta`
                                    )
                                    VALUES(?, ?)");
        $query->bind_param('ii',$idUsuario,$id_pregunta);
        return $query->execute();
    }

    public function getPreguntaVistaById($id)
    {
        $query = $this->db->prepare("SELECT * FROM `pregunta_vista` WHERE id_pregunta_vista = ?");
        $query->bind_param('i',$id);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC);
    }
    
    
    public function getRespuestaById($id_respuesta){
        $query = $this->db->prepare("SELECT * FROM `respuesta` WHERE id_respuesta = ?");
        $query->bind_param('i',$id_respuesta);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC);
        
    }
    

}