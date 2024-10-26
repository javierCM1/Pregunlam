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

    public function obtenerUltimoIdPreguntas()
    {
        $query = $this->db->prepare("SELECT MAX(id_pregunta) FROM `pregunta`");
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC)['MAX(id_pregunta)'];
    }

    public function obtenerCantidadPreguntasPorEstado($estado)
    {
        $query = $this->db->prepare("SELECT COUNT(id_pregunta) FROM `pregunta` WHERE id_estado = ?");
        $query->bind_Param('i',$estado);
        $query->execute();
        return $query->get_result()->fetch_array(MYSQLI_ASSOC)['COUNT(id_pregunta)'];
    }

    public function obtenerIdsPreguntasActivasNoVistasPorIdUsuario($idUusario)
    {
        $estado = 2;
        $query = $this->db->prepare("SELECT id_pregunta FROM pregunta P WHERE id_estado = ? 
                                                                        AND NOT EXISTS(SELECT 1 FROM `pregunta_vista` PV 
                                                                                        WHERE PV.id_pregunta=P.id_pregunta
                                                                                        AND id_usuario = ?)");
        $query->bind_param('ii', $estado,$idUusario);
        $query->execute();
        return $query->get_result()->fetch_all();
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

    public function obtenerPreguntaAleatoria($idUsuario)
    {
        $arrayId = $this->obtenerIdsPreguntasActivasNoVistasPorIdUsuario($idUsuario);
        return $this->obtenerPreguntaPorId(array_rand($arrayId),2);
    }

    /**
     * @throws PreguntaExpiradaException
     */
    public function getUltimaPreguntaEntregadaDePartida($idPartida)
    {
        $estado = 'a';
        $respondio = 0;
        $respondeCorrecto = 0;
        $query = $this->db->prepare("SELECT PP.id_pregunta, PP.fechaHoraEntrega_pregunta_partida FROM pregunta_partida PP
                                    JOIN partida PA ON PA.id_partida=PP.id_partida
                                    WHERE PA.estado_partida = ? 
                                    AND PP.id_partida = ? 
                                    AND PP.respondio_pregunta_partida = ?
                                    AND PP.respondeCorrecto_pregunta_partida = ?");
        $query->bind_param('siii',$estado,$idPartida,$respondio,$respondeCorrecto);
        $query->execute();
        $result = $query->get_result()->fetch_array(MYSQLI_ASSOC);

        if($result != null) {
            if(time()-strtotime($result['fechaHoraEntrega_pregunta_partida']) > 30) {
                throw new PreguntaExpiradaException();
            }
            return $this->obtenerPreguntaPorId($result['id_pregunta'],2);
        }
        return null;
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

    public function respuestaEsCorrecta($respuesta)
    {
        return $respuesta['esCorrecta_respuesta'] === 1;
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

    public function respondePregunta($idPartida,$idPregunta)
    {
        $responde = 1;
        $query = $this->db->prepare("UPDATE pregunta_partida SET respondio_pregunta_partida = ? WHERE id_partida = ? AND id_pregunta = ?");
        $query->bind_param('iii', $responde, $idPartida, $idPregunta);
        return $this->db->executeStmt($query) == 1;
    }

    public function respondeCorrecto($idPartida,$idPregunta)
    {
        $respondeCorrecto = 1;
        $query = $this->db->prepare("UPDATE pregunta_partida SET respondeCorrecto_pregunta_partida = ? WHERE id_partida = ? AND id_pregunta = ?");
        $query->bind_param('iii', $respondeCorrecto, $idPartida, $idPregunta);
        return $this->db->executeStmt($query) == 1;
    }

}