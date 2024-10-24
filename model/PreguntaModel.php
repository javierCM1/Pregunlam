<?php


class PreguntaModel
{
    
    
    private $db;
    
    
    public function __construct($database)
    {
        $this->db = $database;
    }
    
    
    /*public function saveEstado($estado)
    {
        
        $query = $this->db->prepare("INSERT INTO estado (
                    id_estado,
                descripcion_estado
                ) VALUES (?, ?)");
        
        $descripcion_estado = $estado->getDescripcion();
        $id_estado = $estado->getId();
        
        $query->bind_Param("is", $id_estado, $descripcion_estado);
        return $query->execute();
        
        
    }*/
    
    
    /*public function saveCategoria($categoria)
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
        
        
        
    }*/

    public function obtenerCantidadDePreguntas()
    {
        $query = $this->db->prepare("SELECT COUNT(id_pregunta) FROM `pregunta`");
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC)['COUNT(id_pregunta)'];
    }
    
    public function savePregunta($interrogante,$idUsuarioCreador,$idCategoria,$idEstado)
    {
        $query = $this->db->prepare("INSERT INTO `pregunta`(
                                        `interrogante_pregunta`,
                                        `fechaCreacion_pregunta`,
                                        `id_usuarioCreador`,
                                        `id_categoria`,
                                        `id_estado`
                                    ) VALUES (?,NOW(),?,?,?)");

        $query->bind_Param("siii",$interrogante,$idUsuarioCreador,$idCategoria,$idEstado);
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




}